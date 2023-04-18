import requests
import csv

"""
This code scrapes the html from IMDB cast and crew pages. 
The csv it retrieves the URLS from should be formatted like rockdata.csv, with the link to the cast and crew pages for each respective film as the 6th item 
on each line. Alternatively, you can manipulate the code beginning on line 28 to take a list of tuples or something with the name of the film and the link to
the imdb cast+crew page.
It will print the html for each film in a separate file. 

Before you run this code, make sure that you have a folder titled "imdb_cast_crew_scraped" in your working directory. This is where it will output the raw html.
"""


header={'user-agent': '[Your Name]', } # replace w your name and credentials


def gethtml(title, imdb):
    """
    
    """
    html = requests.get(imdb, headers=header)
    htmltext = html.text
    with open(f"imdb_cast_crew_scraped/{title}_castcrew", 'w') as f: 
        f.write(title)
        f.write(htmltext)
    print(html.encoding)

with open("rockdata.csv", 'r') as f:
    csv_reader = csv.reader(f, delimiter=",")
    for row in csv_reader:
        if "imdb" in row[6]:
            title = row[0]
            # print(title)
            imdb = row[6]
            # print(imdb)
            gethtml(title, imdb)
