#TODO: Reconcile why there are only 88 files (my other directory had 89)
#TODO Find out how to parse names from html. Need to be based on the h4 
# class of dataheaderwithborder it's under?

from unittest import skip
import requests
import csv
import glob
from bs4 import BeautifulSoup
import re


# header={'user-agent': 'simonlaraway', }

# imdb = "https://www.imdb.com/title/tt0181136/fullcredits/?ref_=tt_cl_sm"

# title = 'Vivir de sueños'

# def gethtml(title, imdb):
#     html = requests.get(imdb, headers=header)
#     htmltext = html.text
#     with open(f"imdb_cast_crew_scraped/{title}_castcrew", 'w') as f: 
#         f.write(title)
#         f.write(htmltext)
#     print(html.encoding)

# with open("rockdata.csv", 'r') as f:
#     csv_reader = csv.reader(f, delimiter=",")
#     for row in csv_reader:
#         if "imdb" in row[6]:
#             title = row[0]
#             # print(title)
#             imdb = row[6]
#             # print(imdb)
#             gethtml(title, imdb)

"""
Use the below to clean the texts for special characters
"""

# text = """sc-bfec09a1-1 fUguci">Ang\xc3\xa9lica Mar\xc3\xada</a><div "sc-bfec09a1-1 fUguci">Fernando Luj\xc3\xa1n</a><div claci">Agust\xc3\xadn Mart\xc3\xadnez Solares</"""

# def cleantextfunc(text): 
#     text1 = re.sub("\xc3\xa9", "é", text)
#     text2 = re.sub("\xc3\xad", "í", text1)
#     text3 = re.sub("\xc3\xb3", "ó", text2)
#     text4 = re.sub("\xc3\xba", "ú", text3)
#     text5 = re.sub("\xc3\xa1", "á", text4)
#     text6 = re.sub("\xc3\x93", "Ó", text5)
#     text7 = re.sub("\xc3\x8d", "Í", text6)
#     text8 = re.sub("\xc3\x89", "É", text7)
#     text9 = re.sub("\xc3\x9a", "Ú", text8)
#     text10 = re.sub("\xc3\x81", "Á", text9)
#     return text10

# # print(cleantextfunc(text))

"""
Use the above to clean the texts for special characters
"""



"""
The below functions to get the top cast from the imdb main page of the film. 
"""

def writecast(item, filmtitle): 
    """
    #this needs to get the name of the cast and a link to their imdb page? should I do the 
    imdb page for the rest of the cast as well?
    """
    with open(file, 'r') as f:
       soup = BeautifulSoup(f.read(), 'html.parser')
       evenorodd = ["even", "odd"]
       cast = soup.find_all("tr", evenorodd)
       with open(f"Cast/{filmtitle}CAST.csv", "w") as f: # fix to have name of title
            f.write(filmtitle + "_cast,role,imdb_page" + "\n")
            for item in cast:
                href = re.findall(r"\"(.[^<>]+)\"", str(item.a))
                itemgood = re.sub(r"          |\.\.\.|^\s|\n", '', item.text)
                itembetter = re.sub(r"     ", ",", itemgood)
                itembest = re.sub(r"  ", '', itembetter)
                if href:
                    f.write(itembest + "," + "https://www.imdb.com/" + str(href[0]) + "\n")
                else:
                    f.write(itembest + "\n")
        
    # print(item)

path = "/Users/simonlaraway/Desktop/collectimdb/imdb_cast_crew_scraped/*"

# /Users/simonlaraway/Desktop/collectimdb/imdb_cast_crew_scraped/5 de chocolate y 1 de fresa _castcrew

for file in glob.glob(path):
    with open(file, 'r') as f:  # this needs to be inside a function that takes the title of the film as an arg and the file as an arg
        filmtitle = re.sub(r"ed/|_cast", '', re.search(r"ed/(.+)_cast", file).group())  # remove this and put a variable for the film title
        soup = BeautifulSoup(f.read(), 'html.parser')
        firstparameter = ["h4", "td"]
        classparameter = ["dataHeaderWithBorder", "name"] 
        items = soup.find_all(firstparameter, classparameter)
        with open(f"Crew/{filmtitle}.csv", "w") as f:  # fix to have name of title
            f.write(filmtitle + "_cast_member," + "imdb_page" + "\n")
            for item in items:
                href = re.findall(r"\"(.+)\"", str(item.a))
                if "Cast" in item.text:
                    writecast(item.text, filmtitle)
                else:
                    itemgood = re.sub(r"          |\.\.\.|^\s|\n", '', item.text)
                    if href:
                        f.write(itemgood + "," + "https://www.imdb.com/" + str(href[0]) + "\n")
                    else:
                        f.write(itemgood + "\n")

"""
The above functions to get the top billed cast from the imdb main page of the film. Repurpose to work for
the cast/crew page
"""



"""Working code below"""



# def writecast(item, filmtitle): 
#     """
#     #this needs to get the name of the cast and a link to their imdb page? should I do the 
#     imdb page for the rest of the cast as well?
#     """
#     with open(file, 'r') as f:
#        soup = BeautifulSoup(f.read(), 'html.parser')
#        evenorodd = ["even", "odd"]
#        cast = soup.find_all("tr", evenorodd)
#        with open("FiletestCAST.csv", "w") as f: # fix to have name of title
#             f.write(filmtitle + "_cast,role,imdb_page" + "\n")
#             for item in cast:
#                 href = re.findall(r"\"(.[^<>]+)\"", str(item.a))
#                 itemgood = re.sub(r"          |\.\.\.|^\s|\n", '', item.text)
#                 itembetter = re.sub(r"     ", ",", itemgood)
#                 itembest = re.sub(r"  ", '', itembetter)
#                 if href:
#                     f.write(itembest + "," + "https://www.imdb.com/" + str(href[0]) + "\n")
#                 else:
#                     f.write(itembest + "\n")





# with open(file, 'r') as f:  # this needs to be inside a function that takes the title of the film as an arg and the file as an arg
#     filmtitle = "7 Dias"  # remove this and put a variable for the film title
#     soup = BeautifulSoup(f.read(), 'html.parser')
#     firstparameter = ["h4", "td"]
#     classparameter = ["dataHeaderWithBorder", "name"] 
#     items = soup.find_all(firstparameter, classparameter)
#     with open("Filetest.csv", "w") as f:  # fix to have name of title
#         f.write(filmtitle + "_cast_member," + "imdb_page" + "\n")
#         for item in items:
#             href = re.findall(r"\"(.+)\"", str(item.a))
#             if "Cast" in item.text:
#                 writecast(item.text, filmtitle)
#             else:
#                 itemgood = re.sub(r"          |\.\.\.|^\s|\n", '', item.text)
#                 if href:
#                     f.write(itemgood + "," + "https://www.imdb.com/" + str(href[0]) + "\n")
#                 else:
#                     f.write(itemgood + "\n")


