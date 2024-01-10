import requests

links = [
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4-ORWzVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4-ORWoVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4-ORWpVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4-ORWnVaE.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKZ-Go6G5tXcraBGwCYdA.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKZ-Go6G5tXcraaGwCYdA.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKZ-Go6G5tXcrabGwCYdA.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKZ-Go6G5tXcraVGwA.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr5mOBWzVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr5mOBWoVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr5mOBWpVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr5mOBWnVaE.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4uPhWzVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4uPhWoVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4uPhWpVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4uPhWnVaE.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4WPBWzVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4WPBWoVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4WPBWpVaF5NQ.woff2',
    'https://fonts.gstatic.com/s/kanit/v15/nKKU-Go6G5tXcr4WPBWnVaE.woff2',
]

for link in links:
    r = requests.get(link)
    with open(f"{link.split('/')[-1]}", "wb") as f:
        f.write(r.content)
        f.close()
