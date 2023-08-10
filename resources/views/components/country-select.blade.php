<div>
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
    <select name="country" id="country">
        @foreach ( $countries as $code => $name )
            <option value="{{ $code }}" @if( $code == $selected ) selected @endif >{{ $name }}</option>
        @endforeach
    </select>
</div>