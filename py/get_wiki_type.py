# -*- coding: utf-8 -*
import urllib
import urllib.request
from bs4 import BeautifulSoup
# 通过角色名抓取职业信息
name_list = ['喵星人','罗曼祭司','高级女仆','护士学生','修道院长','扭蛋战队P','毛熊同好会','医务社员','采药专家','黄道军阿库里埃斯','涅斯军乐队','蓝骑士·比乌斯','蓝骑士阿雷西亚','飞翼骑士','南方警备队员','修道院守护者','绝地武士','勇犬剑士','扭蛋战队R','报丧女妖','剑道社员','狼族卫士','巴伦西亚骑士','黄道军阿莉耶丝','蓝骑士·大卫','蓝骑士里尼亚','罗曼士兵','皇家亲卫队','海军大将','贝尔·格里尔斯','扭蛋战队K','安德烈','恶魔同好会','皇家稽查队','冰川矿工','记者','黄道军韬','女神教守护骑士','蓝骑士尤格林','狐狸射手','机械少女','小丑','丝绒射手','动物同好会','扭蛋战队Y','极地猎人','弓道社员','寒冰射手','涅斯革命军的弓手','黄道军比尔高','圣都巡礼者','蓝骑士艾米莉亚','猎人莱瑟','扭蛋战队G','南方亲卫队','女警','魔导工程师','小红帽','古惑仔','音乐同好会','猎鹰精英','喵奇奇','豹女郎','黄道军双胞胎','蓝骑士·杰西','蓝骑士拉伊勒','暴风忍者团','涅斯军团女巫','吸血鬼','阿尔卑斯少女','扭蛋战队B','顿悟的海獭','机械少女-0','超自然同好会','冰霜法师','黄道军蛇夫','主持人','蓝骑士·拉维亚','女神教异端审判者']
for name in name_list:
     response = urllib.request.urlopen('http://wiki.joyme.com/cq/'+urllib.parse.quote(name))
     html = response.read()
     res = BeautifulSoup(html,"html.parser")
     for tag1 in res.find_all('div', class_='hero-info-block hero-info-stat'):
          r_name = tag1.find('a').get('title')
          with open("result_type_normal.txt","a") as file:
               file.write(r_name+'\n')
     print(name+" success")