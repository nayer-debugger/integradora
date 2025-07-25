import random
import math

# Activación de su derivada derivada
def sigmoid(x):
    return 1 / (1 + math.exp(-x))

def sigmoid_deriv(x):
    return x * (1 - x)

# Datos simulados (2 características por "imagen")
# Por ejemplo: [orejas_puntiagudas, cola_curva]
datos_entrenamiento = [
    ([0, 0], 0),  # gato
    ([0, 1], 0),  # gato
    ([1, 0], 1),  # perro
    ([1, 1], 1),  # perro
]

# Se inician los datos con datos aleatorios
peso1 = random.random()
peso2 = random.random()
bias = random.random()
tasa_aprendizaje = 0.1

# Entrenamiento
for epoca in range(10000):
    for entrada, salida_esperada in datos_entrenamiento:
        # Eas acia adelante
        suma = entrada[0]*peso1 + entrada[1]*peso2 + bias
        salida = sigmoid(suma)

        # Error
        error = salida_esperada - salida

        # Ajuste de pesos (datos los cuales se tomaron segun la gradiente en en cuanto a su modelo)
        ajuste = error * sigmoid_deriv(salida)
        peso1 += ajuste * entrada[0] * tasa_aprendizaje
        peso2 += ajuste * entrada[1] * tasa_aprendizaje
        bias += ajuste * tasa_aprendizaje

# Prueba de predicción la ia insanita
def predecir(entrada):
    suma = entrada[0]*peso1 + entrada[1]*peso2 + bias
    salida = sigmoid(suma)
    return round(salida)

# Pruebas de predicción
print("Predicción para [0, 0] (esperado: Gato):", predecir([0, 0]))
print("Predicción para [1, 1] (esperado: Perro):", predecir([1, 1]))
print("Predicción para [0, 1] (esperado: Gato):", predecir([0, 1]))
print("Predicción para [1, 0] (esperado: Perro):", predecir([1, 0]))
