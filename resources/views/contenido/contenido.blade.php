@extends('principal')
@section('contenido')
<template v-if="menu==0">
    <h1>jajaj </h1>
</template>

<template v-if="menu==1">
    <categoria></categoria>
</template>

<template v-if="menu==2">
    <libro></libro>
</template>

<template v-if="menu==3">
    <User><User>
</template>
<template v-if="menu==4">
    <rol></rol>
</template>
<template v-if="menu==5">
    <h1>opción 5 --- contenido</h1>
</template>
<template v-if="menu==6">
    <h1>opción 6 --- contenido</h1>
</template>

<template v-if="menu==7">
    <h1>opción 7 --- contenido</h1>
</template>
<template v-if="menu==8">
    <h1>opción 8 --- contenido</h1>
</template>
<template v-if="menu==9">
    <h1>opción 9 --- contenido</h1>
</template>
<template v-if="menu==10">
    <h1>opción 10 --- contenido</h1>
</template>
<template v-if="menu==11">
    <h1>opción 11 --- contenido</h1>
</template>
<template v-if="menu==12">
    <h1>opción 12 --- contenido</h1>
</template>

@endsection