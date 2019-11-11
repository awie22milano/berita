from bs4 import BeautifulSoup
import requests
from selenium import webdriver

driver = webdriver.Chrome()
driver.get('https://news.google.com/stories/CAAqSQgKIkNDQklTTERvSmMzUnZjbmt0TXpZd1NoOGFIV1F0U1ZkSmJsZDVaWEZNVXpCelRYRkVXbXBQU2s4M00wMUhSVGxOS0FBUAE?q=bps&lr=English&hl=id&gl=ID&ceid=ID:id&so=1')
res = driver.execute_script("return document.documentElement.outerHTML")
driver.quit()

soup = BeautifulSoup(res, 'lxml')
box = soup.find('div', {'class': 'lBwEZb BL5WZb xP6mwf'})
containers = box.find_all('div', {'class': 'xrnccd'})

filename = "berita.csv"
f = open(filename, "w")
headers = "header; ringkasan; sumber; tanggal; link\n"
sumber_berita = 'http://news.google.com'

f.write(headers)

for container in containers:
    header = container.find('h3', {'class': 'ipQwMb ekueJc RD0gLb'}).text.replace('\n', '').replace('|', '').replace('–', '').strip()
    ringkasan = container.find('span', {'class': 'xBbh9'}).text.replace('\n', '').replace('|', '').replace('–', '').strip()
    sumber = container.find('a', {'class': 'wEwyrc AVN2gc uQIVzc Sksgp'}).text.replace('\n', '').strip()
    tanggal = container.find('time', {'class': 'WW6dff uQIVzc Sksgp'})['datetime'][0:10]
    link = container.find('a', {'class': 'DY5T1d'})['href'].replace('.', sumber_berita)
       
    print(header, ringkasan, sumber, tanggal, link)

    f.write(header + ";" + ringkasan + ";" + sumber + ";" + tanggal + ";" + link + "\n")

f.close()
