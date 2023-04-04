
"""
This code functions to get the top cast from the imdb cast and crew list page of the film's html. Will output csv files, two for each film:
One CSV file will contain the cast of the film followed by the role they play and the link to their IMDB page. Cast members separated by hard returns.
The other CSV file will contain the crew members of the films and their titles, separated by hard returns. 

Before running this code, make sure you have three things:
1. A file in your working directory called "Cast"
2. A file in your working directory called "Crew"
3. A folder full of files of HTML scraped from the web using the "scrapeimdb.py" code. Put the path to this folder in the path variable.

"""


import glob
from bs4 import BeautifulSoup
import re


def writecast(item, filmtitle): 
    """
    Writes the cast list as a csv.

    item = html from one film containing the cast list, as a string 
    filmtitle = title of film as string
    """
    with open(file, 'r') as f:
       soup = BeautifulSoup(f.read(), 'html.parser')
       evenorodd = ["even", "odd"]
       cast = soup.find_all("tr", evenorodd)
       with open(f"Cast/{filmtitle}CAST.csv", "w") as f: # Make sure to have a folder called "Cast" in your working directory. That is where the files will be output.
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

path = "/Users/simonlaraway/Desktop/collectimdb/imdb_cast_crew_scraped/*" #replace with path to folder containing files with html scraped from IMDB cast and crew pages.

for file in glob.glob(path):
    with open(file, 'r') as f: 
        filmtitle = re.sub(r"ed/|_cast", '', re.search(r"ed/(.+)_cast", file).group())
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

