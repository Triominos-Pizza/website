import keyboard
from time import sleep

ingredients = ["tomate","mozzarella","basilic","pepperoni","ananas","champignon","olives","poulet","boeuf","oignon","jambon","cheddar","parmesan","gorgonzola"]

nb_sec = 5
print(f"Strating in {nb_sec} seconds...")
sleep(nb_sec)
for ingredient in ingredients:
    if keyboard.is_pressed('esc'):
        break

    # Open a new browser tab
    keyboard.press_and_release('ctrl+t')
    sleep(0.5)

    # Search for the ingredient on google image (filters : transparent png, square)
    keyboard.write(f'https://www.google.com/search?q={ingredient}%20png%20square&tbm=isch&tbs=ic:trans')
    sleep(0.5)
    keyboard.press_and_release('enter')
    sleep(1.5)
    