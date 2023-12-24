import requests
import os

allergens = [
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/fish_allergen_food_allergens_icon_183728.png",       "poisson"        ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/milk_allergen_food_allergens_icon_183724.png",       "lait"           ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/sulfites_allergen_food_allergens_icon_183725.png",   "sulfites"       ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/egg_allergen_food_allergens_icon_183730.png",        "oeufs"          ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/gluten_allergen_food_allergens_icon_183726.png",     "gluten"         ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/crustacean_allergen_food_allergens_icon_183733.png", "crustaces"      ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/soy_allergen_food_allergens_icon_183721.png",        "soja"           ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/peanuts_allergen_food_allergens_icon_183731.png",    "arachide"       ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/nuts_allergen_food_allergens_icon_183722.png",       "fruits_a_coque" ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/celery_allergen_food_allergens_icon_183723.png",     "celeri"         ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/mustard_allergen_food_allergens_icon_183732.png",    "moutarde"       ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/shellfish_allergen_food_allergens_icon_183727.png",  "mollusques"     ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/sesame_allergen_food_allergens_icon_183729.png",     "sesame"         ),
    ("https://cdn.icon-icons.com/icons2/2940/PNG/512/lupins_allergen_food_allergens_icon_183720.png",     "lupin"          ),
]

for allergen in allergens:
    headers = {
        "User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 \
        (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36"
    }
    r = requests.get(allergen[0], headers=headers)
    with open(f"{allergen[1]}.png", "wb") as f:
        f.write(r.content)
        f.close()
