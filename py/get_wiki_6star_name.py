# -*- coding: utf-8 -*
# 批量获取wiki全部角色名
import urllib.request
from bs4 import BeautifulSoup
try:
     # 职业页（剑士、骑士……）
     response = urllib.request.urlopen('http://wiki.joyme.com/cq/%E7%A5%AD%E5%8F%B8')
     html = response.read()
     res = BeautifulSoup(html,"html.parser")
     for tag1 in res.find_all('div', class_='hero-list'):
          for tag2 in tag1.find_all('div', class_='hero-icon size-L'):
               r_name = tag2.find('img').get('alt')
               with open("result.txt","a") as file:
                    file.write(r_name+'\n')
     print("completed.")
except:
     print("error.")