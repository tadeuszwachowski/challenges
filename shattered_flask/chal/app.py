from flask import Flask, render_template_string, request

app = Flask(__name__)

@app.get('/')
def index():
    username = request.args.get('name', 'Guest')

    template = f"Hello, {username}!"
    rendered_template = render_template_string(template)

    return rendered_template

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
