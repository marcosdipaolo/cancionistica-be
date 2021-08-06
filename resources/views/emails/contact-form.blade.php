@component('mail::message')
# Formulario de Contacto - Cancionistica.com.ar

De: {{ $name  }}, <{{$email}}>

Mensaje: {{  $message }}

Gracias,<br />
{{ config('app.name') }}
@endcomponent
