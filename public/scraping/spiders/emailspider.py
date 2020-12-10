import scrapy
import re
import csv
import tldextract
from pydispatch import dispatcher
from scrapy import signals
regex = r'\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b'
emailArr = []

with open('./uploads/input1.csv', 'r') as csvfile: 
    csvreader = csv.reader(csvfile) 
    # fields = next(csvreader)
    scrapurls = [] 
    for row in csvreader:
        scrapurls.append(row[0])

class EmailspiderSpider(scrapy.Spider):
    name = 'emailspider'
    start_urls = scrapurls
    def __init__(self,jsondetails="",serverdetails="", *args,**kwargs):
        super(EmailspiderSpider, self).__init__(*args, **kwargs)
        dispatcher.connect(self.spider_closed, signal=signals.spider_closed)
        self.jsondetails = jsondetails
        self.serverdetails=serverdetails
        self.data = []

    def parse(self, response):
        emaildata = []
        global cloneemail
        global emailArr
        cloneemail = []
        items = response.xpath('//a/@href').extract()
        domain = tldextract.extract(response.request.url).domain
        for item in items:
            if re.search(regex, item.replace('mailto:', ''), re.I) != None:
                emaildata.append(item.replace('mailto:', '').split('?')[0])
        if len(emaildata) == 0:
            firstpageEmailcheck = []
            for item in items:
                if (item[0:1] == '/' or item[0:1] == '.' or item[0:1] == 'c') and 'contact' in item:
                    if item[0:1] == '/' in item:                    
                        item = response.request.url + item[1:]
                    elif item[0:1] == '.' in item:                    
                        item = response.request.url + item.replace('../', '')
                    else:
                        item = response.request.url + item
                if response.request.url.split('//')[1].split('/')[0].replace('www.', '') in item and 'contact' in item:
                    firstpageEmailcheck.append(item)
                    yield scrapy.Request(url=item, callback=self.parse_page)
            if firstpageEmailcheck == []:
                emailArr.append({'url': response.request.url, 'mail':['No Email']})

        else:
            if emaildata == []:
                emailArr.append({'url': response.request.url, 'mail':['No Email']})
            else:
                emailArr.append({'url': response.request.url, 'mail':list(set(emaildata))})
    def parse_page(self, response):
        cloneemail = [];
        subitems = response.xpath('//a/@href').extract()
        divitems= response.css('div *::text').extract()
        newitems = subitems + divitems
        for item in newitems:
            if re.search(regex, item.replace('mailto:', ''), re.I) != None:
                if 'document.write' not in item:
                    for r in (("mailto:", ""), ("EMAIL:", "")):
                        item = item.replace(*r)
                    cloneemail.append(item.split('?')[0])
        if cloneemail == []:
            emailArr.append({'url': response.request.url, 'mail':['No Email']})
        else:
            emailArr.append({'url': response.request.url, 'mail':list(set(cloneemail))})

    def spider_closed(self,spider):
        with open('./uploads/input1.csv', 'r') as read_obj, \
            open('./uploads/output.csv', 'w', newline='') as write_obj:
                csv_reader = csv.reader(read_obj)
                # fields = next(csv_reader)
                csv_writer = csv.writer(write_obj)
                # fields.append('Email')
                # csv_writer.writerow(fields)
                for index, row in enumerate(csv_reader):
                    for email in emailArr:
                        if row[0].split('//')[1].split('/')[0].replace('www.', '') in email['url']:
                            row.append(', '.join(email['mail']))
                            csv_writer.writerow(row)
                print(1)