@component('mail::message')
# Tienes un nuevo mensaje de contacto

**Nombre:** {{ $nombreCompleto }}
**Email:**  {{ $email }}

**Mensaje:**
{{ $mensaje }}

Gracias,
{{ config('app.name') }}
@endcomponent
