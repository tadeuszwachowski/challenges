FROM python:3.9

WORKDIR /app

COPY app.py /app
COPY requirements.txt /app
COPY flag.txt /app
COPY templates/* /app/templates/

RUN pip install --no-cache-dir -r requirements.txt

EXPOSE 5000

RUN pip install Flask
ENV FLASK_APP=app.py

CMD ["flask", "run", "--host=0.0.0.0"]
