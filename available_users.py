import sys
from ldap3 import Server, Connection, ALL, NTLM, SUBTREE
import json

if len(sys.argv)<2:
    print("Non mi hai fornito la password ADN!")
    sys.exit(1)

with open('config.json','r') as f:
    conf=json.load(f)

# Configurazione del server LDAP
server = Server(conf['server'], get_info=ALL)

# Creazione della connessione
conn = Connection(
    server, 
    user=conf['user'],
    password=sys.argv[1],
    authentication=NTLM, 
    auto_bind=True
)

# Esecuzione della query
conn.search(
    conf['dir'],
    '(physicaldeliveryofficename='+conf['office']+')',
    attributes=['name', 'userprincipalname']
)

# Recupero dei risultati
buf=[]
for entry in conn.entries:
    print(entry.name, entry.userprincipalname)
    buf.append(str(entry.name))

# Chiusura della connessione
conn.unbind()
with open('available_users.json','w') as f:
    json.dump(buf,f)
