@extends('principal')
@section('contenido')

@if(Auth::check())

        @if(Auth::user()->idrol == 1)    
            <template v-if="menu==0"><h1>Escritorio</h1></template>
            <template v-if="menu==1"> <categoria></categoria></template>
            <template v-if="menu==2"><libro></libro></template>
            <template v-if="menu==3"> <User><User></template>
            <template v-if="menu==4"><rol></rol></template>
            <template v-if="menu==9"><h1>Reporte Visitas</h1></template>
            <template v-if="menu==10"><h1>Reporte Bibliotecario</h1></template>
            <template v-if="menu==11"><h1>Ayuda </h1></template>
            <template v-if="menu==12"><h1>Acerca de </h1></template>            
        @elseif(Auth::user()->idrol == 2)
            <template v-if="menu==1"> <categoria></categoria></template>
            <template v-if="menu==2"><libro></libro></template>
            <template v-if="menu==9"><h1>Reporte Visitas</h1></template>
            <template v-if="menu==10"><h1>Reporte Bibliotecario</h1></template>
            <template v-if="menu==11"><h1>Ayuda </h1></template>
            <template v-if="menu==12"><h1>Acerca de </h1></template> 
        @elseif(Auth::user()->idrol == 3)
            <template v-if="menu==2"><libro></libro></template>
            <template v-if="menu==9"><h1>Reporte Visitas</h1></template>
            <template v-if="menu==11"><h1>Ayuda </h1></template>
            <template v-if="menu==12"><h1>Acerca de </h1></template> 
        @else

        @endif    
            
    @endif
@endsection