import requests
from bs4 import BeautifulSoup
from urllib.parse import urljoin, urlparse
import time
import os
from pathlib import Path
import json

class CakePHPScraper:
    def __init__(self, base_url="https://book.cakephp.org/5.x/"):
        self.base_url = base_url
        self.domain = urlparse(base_url).netloc
        self.visited_urls = set()
        self.to_visit = set([base_url])
        self.scraped_data = {}
        self.session = requests.Session()
        self.session.headers.update({
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        })
        
    def is_same_domain(self, url):
        parsed = urlparse(url)
        return (parsed.netloc == self.domain and 
                parsed.path.startswith('/5.x/') and 
                '/ja/' not in parsed.path)
    
    def get_absolute_url(self, url):
        return urljoin(self.base_url, url)
    
    def extract_links(self, soup, current_url):
        links = set()
        for link in soup.find_all('a', href=True):
            href = link['href']
            if href.startswith('#') or href.startswith('javascript:'):
                continue
            
            absolute_url = self.get_absolute_url(href)
            if self.is_same_domain(absolute_url):
                links.add(absolute_url)
        return links
    
    def extract_content(self, soup, url):
        content = {
            'url': url,
            'title': self.extract_title(soup),
            'headers': self.extract_headers(soup),
            'paragraphs': self.extract_paragraphs(soup),
            'code_blocks': self.extract_code_blocks(soup),
            'links': self.extract_all_links(soup),
            'metadata': self.extract_metadata(soup)
        }
        return content
    
    def extract_title(self, soup):
        title = soup.find('title')
        return title.get_text().strip() if title else ''
    
    def extract_headers(self, soup):
        headers = {}
        for i in range(1, 7):
            header_tags = soup.find_all(f'h{i}')
            headers[f'h{i}'] = [header.get_text().strip() for header in header_tags]
        return headers
    
    def extract_paragraphs(self, soup):
        paragraphs = []
        for p in soup.find_all('p'):
            text = p.get_text().strip()
            if text:
                paragraphs.append(text)
        return paragraphs
    
    def extract_code_blocks(self, soup):
        code_blocks = []
        for code in soup.find_all(['code', 'pre']):
            code_text = code.get_text().strip()
            if code_text:
                code_blocks.append({
                    'language': code.get('class', [''])[0] if code.get('class') else '',
                    'content': code_text
                })
        return code_blocks
    
    def extract_all_links(self, soup):
        links = []
        for link in soup.find_all('a', href=True):
            links.append({
                'text': link.get_text().strip(),
                'url': self.get_absolute_url(link['href']),
                'is_external': not self.is_same_domain(self.get_absolute_url(link['href']))
            })
        return links
    
    def extract_metadata(self, soup):
        meta_tags = soup.find_all('meta')
        metadata = {}
        for meta in meta_tags:
            name = meta.get('name') or meta.get('property') or meta.get('http-equiv')
            if name and meta.get('content'):
                metadata[name] = meta.get('content')
        return metadata
    
    def scrape_page(self, url):
        try:
            response = self.session.get(url, timeout=10)
            response.raise_for_status()
            
            soup = BeautifulSoup(response.content, 'html.parser')
            content = self.extract_content(soup, url)
            
            new_links = self.extract_links(soup, url)
            for link in new_links:
                if link not in self.visited_urls and link not in self.to_visit:
                    self.to_visit.add(link)
            
            self.scraped_data[url] = content
            self.visited_urls.add(url)
            
            print(f"✓ Scraped: {url}")
            return True
            
        except requests.RequestException as e:
            print(f"✗ Failed to scrape {url}: {e}")
            return False
        except Exception as e:
            print(f"✗ Error processing {url}: {e}")
            return False
    
    def run(self, max_pages=100, delay=1):
        print(f"Starting scrape of {self.base_url}")
        print(f"Domain: {self.domain}")
        print("-" * 50)
        
        pages_scraped = 0
        
        while self.to_visit and pages_scraped < max_pages:
            current_url = self.to_visit.pop()
            
            if current_url in self.visited_urls:
                continue
            
            if self.scrape_page(current_url):
                pages_scraped += 1
                
            time.sleep(delay)
        
        print(f"\nScraping completed!")
        print(f"Pages visited: {len(self.visited_urls)}")
        print(f"Pages remaining in queue: {len(self.to_visit)}")
        
        return self.scraped_data
    
    def save_results(self, output_dir="scraped_data"):
        os.makedirs(output_dir, exist_ok=True)
        
        json_file = os.path.join(output_dir, "cakephp_docs.json")
        with open(json_file, 'w', encoding='utf-8') as f:
            json.dump(self.scraped_data, f, indent=2, ensure_ascii=False)
        
        for url, content in self.scraped_data.items():
            safe_filename = url.replace('https://', '').replace('http://', '').replace('/', '_')
            if len(safe_filename) > 100:
                safe_filename = safe_filename[:100] + "_" + str(hash(url))[-8:]
            
            txt_file = os.path.join(output_dir, f"{safe_filename}.txt")
            with open(txt_file, 'w', encoding='utf-8') as f:
                f.write(f"URL: {url}\n")
                f.write(f"Title: {content.get('title', '')}\n")
                f.write("=" * 80 + "\n\n")
                
                f.write("HEADERS:\n")
                for header_level, headers in content.get('headers', {}).items():
                    if headers:
                        f.write(f"{header_level.upper()}:\n")
                        for header in headers:
                            f.write(f"  - {header}\n")
                f.write("\n" + "=" * 80 + "\n\n")
                
                f.write("CONTENT:\n")
                for paragraph in content.get('paragraphs', []):
                    f.write(f"{paragraph}\n\n")
                
                f.write("\n" + "=" * 80 + "\n\n")
                f.write("CODE BLOCKS:\n")
                for i, code_block in enumerate(content.get('code_blocks', []), 1):
                    f.write(f"Code Block {i} ({code_block.get('language', 'unknown')}):\n")
                    f.write(f"{code_block.get('content', '')}\n")
                    f.write("-" * 40 + "\n\n")
        
        print(f"Results saved to {output_dir}/")
        print(f"- JSON file: {json_file}")
        print(f"- Individual text files: {len(self.scraped_data)} files")

def main():
    scraper = CakePHPScraper()
    
    # Remove max_pages limit to scrape all 5.x documentation
    scraped_data = scraper.run(max_pages=1000, delay=0.1)
    
    scraper.save_results()
    
    print("\nScraping Summary:")
    print(f"Total pages scraped: {len(scraped_data)}")
    
    total_paragraphs = sum(len(page.get('paragraphs', [])) for page in scraped_data.values())
    total_code_blocks = sum(len(page.get('code_blocks', [])) for page in scraped_data.values())
    
    print(f"Total paragraphs: {total_paragraphs}")
    print(f"Total code blocks: {total_code_blocks}")

if __name__ == "__main__":
    main()