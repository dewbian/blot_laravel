@extends('layouts.app')  

@section('content')  
<Thechat  v-bind:current-user="{{ auth()->id() }}"  ></Thechat>
@endsection
