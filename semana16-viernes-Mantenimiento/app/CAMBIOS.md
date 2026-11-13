# Registro de cambios · TaskBoard API

## AAAA-MM-DD
### Corregido
- MT-013: GET /api/transacciones responde 422 si ?estado no es
  Iniciada, Completada o Fallida (antes: 200 con lista vacía).
  ⚠ Clientes que enviaban estados mal escritos verán 422.

### Agregado
- MT-014: GET /api/transacciones/filtrar acepta dos parámetros opcionales,
  monto_min y monto_max (números mayores o iguales a 0; monto_max debe ser
  mayor o igual que monto_min cuando se envían los dos). Sin ellos, la
  respuesta es idéntica a la de antes: no cambió ningún parámetro, campo
  ni código de respuesta existente.