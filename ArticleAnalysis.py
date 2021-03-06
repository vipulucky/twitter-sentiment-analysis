import re

maps = dict()
arousal = dict()
dominance = dict()
finn = dict()

def init():   
    with open("words.csv") as f:
        for line in f:
            word = line.split(",");
            maps[word[0]] = word[2];
            arousal[word[0]] = word[4];
            dominance[word[0]] = word[6];
    with open("finn.csv") as f:
        for line in f:
            word = line.split(",");
            finn[word[0]] = word[1];

def analyse(article):
    output = ""
    output += "<b>Tweet: </b>" + article + "<br>"
    values = article
    words = values.split(" ")
    output += "<b>Words: </b>"+str(len(words))+"<br>"
    c=float(0)
    s=float(0)
    for i in range(0,len(words)):
        if words[i] in maps:
            s = s + float(maps[words[i]])
            c += 1
    output += "<h5>ANEW:</h5>Found total of "+str(c)+" words in ANEW lexicon<br>"
    if c == 0:
        avg=0
    else:
        avg = float(s/c)
    output += "<b>Happiness: </b>"+str(avg)+"<br>"
    c=float(0)
    s=float(0)
    for i in range(0,len(words)):
        if words[i] in arousal:
            s = s + float(arousal[words[i]])
            c += 1
    if c == 0:
        avg=0
    else:
        avg = float(s/c)
    output += "<b>Arousal: </b>"+str(avg)+"<br>"
    c=float(0)
    s=float(0)
    for i in range(0,len(words)):
        if words[i] in dominance:
            s = s + float(dominance[words[i]])
            c += 1
    if c == 0:
        avg=0
    else:
        avg = float(s/c)
    output += "<b>Dominance: </b>"+str(avg)+"<br>"
    c=float(0)
    s=float(0)
    for i in range(0,len(words)):
        if words[i] in finn:
            s = s + float(finn[words[i]])
            c += 1
    output += "<h5>AFINN:</h5>Found total of "+str(c)+" words in FINN lexicon<br>"
    if c == 0:
        avg=0
    else:
        avg = float(s/c)
    output += "<b>Finn Score: </b>"+str(avg)+"<br>"
    return output

result = "<header><h3>The Scores</h3></header><p>"
init()
with open("article.txt") as f:
        for tmp in f:
            tmp = tmp.replace("'"," ")
            tmp = re.sub("(http://|http://www\\.|www\\.)", "", tmp)
            tmp = re.sub("[^A-Za-z0-9 ]", "", tmp)
            result += analyse(tmp) + "<br><hr><br>";
print(result+"</p>")
