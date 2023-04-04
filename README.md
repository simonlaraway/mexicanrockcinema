# mexicanrockcinema
Contains the code for collecting and displaying information on mexicanrockcinema.com.

Visit http://mexicanrockcinema.com/ to see the site. 

Project built by me, overseen by Dr. Brian Price (Dept. of Spanish and Portuguese, BYU) and Dr. Jeremy Browne (Office of Digital Humanities, BYU). 

Directory and file explanation: 
+ Cast: This folder contains CSV files containing the cast, the roles they played, and their imdb page URL for each film.
+ Crew: This folder contains CSV files containing the crew title and crew member(s) with the title for each film. 
+ imdb_cast_crew_scraped: This folder contains the raw HTML for the cast and crew list IMDB pages. 
+ Screening Information: This is an incomplete text file with the blurbs pulled from the carteleras containing screening locations, lengths, and premier dates.
+ aggregatedfiles.csv: This file contains all of the cast and crew information for all the films, with each film's respective cast and crew chunks separated by /n/n + ### + /n/n/
+ filmtemplate.css: The CSS for the film page, which lives in the Film Template.
+ filmtemplate.php: The PHP for the film page, which lives in the Film Template.
+ getnames.py: The Python code which extracts the cast and crew names from the raw HTML
+ rockdata.csv: The original csv containing film titles, year of release, director, genre, award noms/wins, and imdb page.
+ scrapeimdb.py: This Python code, using the URLs in rockdata.csv, scrapes the raw HTML containing cast and crew information from the IMDB URLs.

Additional directions and explanations can be found in the comments in the files themselves.
