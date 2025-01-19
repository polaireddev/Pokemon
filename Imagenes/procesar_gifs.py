import os
from PIL import Image, ImageSequence

def process_gifs(input_folder, output_folder):
    print(f"Procesando GIFs desde: {input_folder}")
    print(f"Guardando nuevos GIFs en: {output_folder}")
    
    # Crear la carpeta de salida si no existe
    os.makedirs(output_folder, exist_ok=True)
    
    # Iterar sobre todos los archivos en la carpeta de entrada
    for filename in os.listdir(input_folder):
        if filename.lower().endswith('.gif'):  # Asegurarse de que sea un archivo GIF
            input_path = os.path.join(input_folder, filename)
            print(f"Procesando archivo: {input_path}")
            
            # Abrir el archivo GIF
            with Image.open(input_path) as original_gif:
                # Procesar el fondo rojo
                red_gif_path = os.path.join(output_folder, f"{os.path.splitext(filename)[0]}_R.gif")
                create_gif_with_background(original_gif, red_gif_path, (255, 0, 0, 255))  # Rojo
                
                # Procesar el fondo verde
                green_gif_path = os.path.join(output_folder, f"{os.path.splitext(filename)[0]}_V.gif")
                create_gif_with_background(original_gif, green_gif_path, (0, 255, 0, 255))  # Verde
    print("¡Procesamiento completado!")

def create_gif_with_background(original_gif, output_path, background_color):
    frames = []
    # Iterar por cada frame del GIF original
    for frame in ImageSequence.Iterator(original_gif):
        frame = frame.convert("RGBA")  # Convertir el frame a RGBA
        # Crear una capa de fondo del color especificado
        background = Image.new("RGBA", frame.size, background_color)
        # Combinar el frame con el fondo
        combined = Image.alpha_composite(background, frame)
        frames.append(combined)
    
    # Guardar el nuevo GIF con el fondo modificado
    frames[0].save(output_path, save_all=True, append_images=frames[1:], loop=0, duration=original_gif.info['duration'])
    print(f"Guardado GIF: {output_path}")

# Configuración de carpetas
input_folder = r"D:\Desarollo Web\GOld"  # Carpeta con los GIFs originales
output_folder = r"D:\Desarollo Web\GFondoNew"  # Carpeta donde se guardarán los nuevos GIFs

# Ejecutar el procesamiento
process_gifs(input_folder, output_folder)
