import os
import requests

allergens = [("https://cdn.icon-icons.com/icons2/2940/PNG/512/fish_allergen_food_allergens_icon_183728.png", "Fish"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/milk_allergen_food_allergens_icon_183724.png", "Milk"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/sulfites_allergen_food_allergens_icon_183725.png", "Sulfites"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/egg_allergen_food_allergens_icon_183730.png", "Egg"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/gluten_allergen_food_allergens_icon_183726.png", "Gluten"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/crustacean_allergen_food_allergens_icon_183733.png", "Crustacean"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/soy_allergen_food_allergens_icon_183721.png", "Soy"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/peanuts_allergen_food_allergens_icon_183731.png", "Peanuts"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/nuts_allergen_food_allergens_icon_183722.png", "Nuts"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/celery_allergen_food_allergens_icon_183723.png", "Celery"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/mustard_allergen_food_allergens_icon_183732.png", "Mustard"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/shellfish_allergen_food_allergens_icon_183727.png", "Shellfish"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/sesame_allergen_food_allergens_icon_183729.png", "Sesame"),("https://cdn.icon-icons.com/icons2/2940/PNG/512/lupins_allergen_food_allergens_icon_183720.png", "Lupins"),]

for allergen in allergens:
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML,"
        " like Gecko) Chrome/80.0.3987.149 Safari/537.36"
    }
    r = requests.get(allergen[0], headers=headers)
    print(f"Downloading {allergen[1]}.png : {r.status_code}")
    with open(allergen[1].lower() + ".png", "wb") as f:
        f.write(r.content)
