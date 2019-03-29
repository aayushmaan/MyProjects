import sys
import os
import urllib

def getPageContent():
    page_link = ""
    page = urllib.urlopen(page_link)
    page_content = page.read
    return page_content

def get_next_link(page):
    start_link = page.find('<a href=')
    if start_link == -1:
        return None,0
    start_quote = page.find('"',start_link)
    end_quote = page.find('"',start_quote+1)
    url = page[start_quote+1:end_quote]
    return url,end_quote

def get_all_links(page):
    links=[]
    while True:
        url, end_pos = get_next_link(page)
        if url:
            links.append(url)
            page = page[end_pos:]
        else
            break
    return links
    
def union(p,q):
    for e in q:
        if e not in p:
            p.append(e)
            
            
def page_scraper(seed_page):
    crawled=[]
    to_crawl = [seed]
    while to_crawl:
        page = to_crawl.pop()
        if page not in crawled:
            union(tocrawl,get_all_links(page))
            crawled.append(page)
    return crawled
    

def crawl_web(seed,max_depth):    
    tocrawl = [seed]
    crawled = []
    next_depth = []# Keep track of next level of links
    depth = 0
    while tocrawl and depth <= max_depth:
        page = tocrawl.pop()
        if page not in crawled:
            union(next_depth, get_all_links(get_page(page)))
            crawled.append(page)
        if not tocrawl:
        # When tocrawl is empty, it means this level is all crawled and ready to craw next level
            tocrawl, next_depth = next_depth, []
            depth = depth + 1
    return crawled

