import logging
import re
import csv
import sys
from linkedin_jobs_scraper import LinkedinScraper
from linkedin_jobs_scraper.events import Events, EventData
from linkedin_jobs_scraper.query import Query, QueryOptions, QueryFilters
from linkedin_jobs_scraper.filters import RelevanceFilters, TimeFilters, TypeFilters, ExperienceLevelFilters
logging.basicConfig(level = logging.INFO)

with open('./uploads/linkedin.csv', 'w', newline='') as write_obj:
    # csv.writer(write_obj).writerow(["Job Application Position", "Company", "Job Linked in", "Focus", "Lab", "Application", "Public", "Associate", "Position", "Email", "LI", "Degrees", "Role", "Focus", "Notes", "Proposed Tool/Co", "Organization Type"])
    csv.writer(write_obj).writerow(["Job Title", "Job Function", "Company", "Company Place", "Job Linked in", "Publish Date", "Seniority Level", "Employment Type", "Industries", "Description"])

def on_data(data: EventData):
    with open('./uploads/linkedin.csv', 'a', newline='') as write_obj:
            csv_writer = csv.writer(write_obj)
            csv_writer.writerow([data.title, data.job_function, data.company, data.place, 'https://www.linkedin.com/jobs/view/'+data.job_id+'/', data.date, data.seniority_level, data.employment_type, data.industries, data.description[0:100]])



def on_error(error):
    print('[ON_ERROR]', error)


def on_end():
    print(1)


scraper = LinkedinScraper(
    chrome_executable_path=None, # Custom Chrome executable path (e.g. /foo/bar/bin/chromedriver) 
    chrome_options=None,  # Custom Chrome options here
    headless=True,  # Overrides headless mode only if chrome_options is None
    max_workers=1,  # How many threads will be spawned to run queries concurrently (one Chrome driver for each thread)
    slow_mo=0.4,  # Slow down the scraper to avoid 'Too many requests (429)' errors
)

# Add event listeners
scraper.on(Events.DATA, on_data)
scraper.on(Events.ERROR, on_error)
scraper.on(Events.END, on_end)
queries = [
    Query(
        query=sys.argv[1],
        options=QueryOptions(
            optimize=False, 
            limit=50  
        )
    ),
  
]

scraper.run(queries)