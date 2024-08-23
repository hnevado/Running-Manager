<h1>Runner Details</h1>
<ul>
    @foreach($runner->getAttributes() as $key => $value)
        <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
    @endforeach
</ul>