Esempio di sistema di login attraverso *Active Directory* e conseguente gestione degli utenti.

Il file di configurazione (config.json) ha il seguente formato…
```
{
    "server": "mcduck.com",
    "dir": "DC=ducks,DC=mcduck,DC=com",
    "user": "donald.duck",
    "office": "Scrooge Mc Duck inc."
}
```

`server` è l'indirizzo dell'AD (o server LDAP),

`dir` è la subdirectory in cui cercare

`user` serve quando non è consentito l'accesso anonimo all'AD,

`office` seleziona solo gli utenti di un certo ufficio all'interno 
    dell'Organizzazione.
