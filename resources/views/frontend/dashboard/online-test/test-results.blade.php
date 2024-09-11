@extends('frontend.dashboard.layouts.master')

@section('content')
<section id="wsus__dashboard">
    <div class="container-fluid">
      @include('frontend.dashboard.layouts.sidebar')

    <h1>Test Results</h1>
    <p>You scored {{ $score }} out of {{ $total }}.</p>
    <p>Correct answers: {{ $score }}</p>
    <p>Incorrect answers: {{ $total - $score }}</p>
    <a href="{{ route('online-test') }}">Take Another Test</a>

</div>
</section>

@endsection
