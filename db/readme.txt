To see the visualization, please run the following query on the website below:

https://dbdiagram.io/d


query:

Table reisen {
  seite text [primary key, note: 'z. B. mallorca.php']
  beschreibung text
}

Table kommentare {
  id integer [primary key, note: 'Kommentar ID']
  name text [not null]
  kommentar text [not null]
  reise_id text [not null, ref: > reisen.seite]
  zeitpunkt datetime [default: `CURRENT_TIMESTAMP`]
}

Table antworten {
  id integer [primary key, note: 'Antwort ID']
  parent_id integer [not null, ref: > kommentare.id]
  name text [not null]
  kommentar text [not null]
  zeitpunkt datetime [default: `CURRENT_TIMESTAMP`]
}
