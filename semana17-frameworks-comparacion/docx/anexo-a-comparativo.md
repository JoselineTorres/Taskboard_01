# Anexo A · Comparativo de frameworks de back-end

Proyecto: TaskBoard, API de pasarela de pagos · Integración de Sistemas, UPED

| Criterio | Laravel | Django (con Django REST Framework) |
|---|---|---|
| Lenguaje y ecosistema | PHP. Paquetes con Composer; Sanctum, la validación y los API Resources vienen en el propio framework. | Python. Paquetes con PyPI; Django REST Framework es un paquete externo necesario para construir APIs. |
| Curva de aprendizaje | Baja para mí: lo he usado a lo largo de todo el curso. | Media: exige aprender Python y el patrón de Django (modelos, vistas, URLs), además de DRF. |
| ORM y acceso a datos | Eloquent; las migraciones se escriben a mano y se aplican con `php artisan migrate`. | Django ORM; `makemigrations` genera las migraciones a partir de los cambios en los modelos. |
| Autenticación de API | Sanctum: varios tokens por usuario y expiración configurable. | `TokenAuthentication` de DRF: token simple; para varios tokens por usuario y expiración se usa un paquete de terceros. |
| Herramientas de pruebas | PHPUnit con `postJson`. | `APITestCase` y `APIClient` de DRF, sobre el `TestCase` de Django. |
| Despliegue y hosting | PHP con Apache o Nginx; hosting compartido económico y muy común. | Servidor de aplicaciones Python (WSGI o ASGI); requiere hosting con Python o un VPS. |
| Escenario donde conviene más | API o aplicación web de un desarrollador o equipo con PHP, con hosting económico y entrega rápida (como TaskBoard). | Portales con mucho contenido y panel de administración listo, en equipos con Python. |

## Conclusión

Para TaskBoard, una API de pasarela de pagos que desarrollo de forma individual con Laravel, elegí Laravel porque (1) mi experiencia con él redujo el tiempo de entrega: construí con él todas las capas de TaskBoard (rutas, Eloquent, Form Requests, Sanctum, API Resources y pruebas); (2) Sanctum, la validación y los Resources vienen en el propio framework, sin ensamblar paquetes; y (3) el hosting PHP es económico y fácil de conseguir, un criterio importante para un proyecto académico. Django sería preferible si yo trabajara en Python o si necesitara un panel de administración listo para personal no técnico, pero en mi caso migrar implicaría reescribir lo ya construido y aprender un lenguaje nuevo sin una ventaja medible para esta API.
