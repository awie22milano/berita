from bs4 import BeautifulSoup
import requests
from selenium import webdriver

driver = webdriver.Chrome()
driver.get('https://www.pegipegi.com/hotel/pekanbaru/1.html?stayYear=2019&stayMonth=11&stayDay=13&stayCount=1&roomCrack=200000&adultNum=2&lowestPriceTemp=51733&highestPriceTemp=8264463&roomCount=1&activeSort=0')
res = driver.execute_script("return document.documentElement.outerHTML")
driver.quit()

soup = BeautifulSoup(res, 'lxml')

box = soup.find('div', {'class': 'widget listResult'})

all_hackathons = box.find_all('div', {'class': 'listContent'})


for sno, hackathon in enumerate(all_hackathons,1):
    nama = hackathon.find('div', {'class': 'title'}).text.replace('\n', '').strip()
    alamat = hackathon.find('div', {'class': 'address'}).text.replace('\n', '').strip()
    harga = hackathon.find('div', {'class': 'diskonPrice'}).text.replace('\n', '').strip()
   
    print(sno, nama, alamat, harga)