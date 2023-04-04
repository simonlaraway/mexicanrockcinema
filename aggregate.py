import glob

path = ["/Users/simonlaraway/Desktop/collectimdb/Cast/*", "/Users/simonlaraway/Desktop/collectimdb/Crew/*"] #replace with correct file path

with open ("rockdata.csv", 'r') as f:
    for line in f:
        print(line)
