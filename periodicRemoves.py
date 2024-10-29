import psycopg2
import csv
import os

connection = psycopg2.connect(
    host='127.0.0.1',
    user='jaynofi',
    password='jaynofi1#book',
    database='phonebook',
    port='6432'
)

# connection = psycopg2.connect(
#     host='52.41.130.39',
#     user='jaynofi',
#     password='jaynofi1#book',
#     database='phonebooktest',
#     port='5432'
# )
cursor = connection.cursor()
delete_query = "DELETE FROM phonebook WHERE Phone=%s"

# move files to pending folder
fromFolder = "/var/www/html/dataset/removals/"
toFolder = "/var/www/html/dataset/pendingremovals/"
files = [f for f in os.listdir(fromFolder) if f.endswith(".csv")]
for filename in files:
    os.rename(fromFolder+filename, toFolder+filename)

# start reading pending files
files = [f for f in os.listdir(toFolder) if f.endswith(".csv")]
for filename in files:
    fullfilepath = toFolder+filename
    try:
        with open(fullfilepath, encoding="utf8") as datafile:
            record_read = 0
            databulk = []
            reader = csv.reader(datafile, delimiter="\n", quotechar='"')
            for row in reader:
                if (row[0].strip()==""): continue
                databulk.append((row[0].strip(),))
                record_read += 1
                if record_read%10000 == 0:
                    cursor.executemany(delete_query, databulk)
                    connection.commit()
                    databulk = []
            if len(databulk)!=0 and len(databulk)<10000:
                cursor.executemany(delete_query, databulk)
                connection.commit()
                databulk = []
                record_read = 0
        # Remove file
        os.remove(fullfilepath)
    except:
        pass
    
cursor.close()
connection.close()
