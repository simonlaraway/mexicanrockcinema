import glob

path = ["/Users/simonlaraway/Desktop/collectimdb/Cast/*", "/Users/simonlaraway/Desktop/collectimdb/Crew/*"]

# /Users/simonlaraway/Desktop/collectimdb/imdb_cast_crew_scraped/5 de chocolate y 1 de fresa _castcrew

# for item in path:
#     for file in glob.glob(item):
#         with open(file, 'r') as f:
#             with open("aggregatedfiles.csv", 'a') as g:
#                 g.write(f.read() + "\n\n" + "###" + "\n\n")

with open ("rockdata.csv", 'r') as f:
    for line in f:
        print(line)