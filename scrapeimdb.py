import requests
import csv



header={'user-agent': '[Your Name]', } # replace w your name and credentials


def gethtml(title, imdb):
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
