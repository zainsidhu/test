@extends('layout.master')
@section('page_title', trans('content.page_title'))
@section('content')

    <section class="well1">
        <div class="container">
            <div class="row">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>

                @endif
                <div class="grid_4">
                    <h2 class="heading">Login</h2>
                    <form method="post" action="{{route('save-contact')}}" class="mailform formInputFontSize">
                        <input type="hidden" name="form-type" value="contact">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <fieldset class="row">
                            <label class="grid_4">
                                <input type="email" required="required" name="email" placeholder="E-Mail Address:"oninvalid="this.setCustomValidity('Please enter valid email address')" oninput="setCustomValidity('')">
                            </label>
                            <br><br>
                            <label class="grid_4">
                                <input type="password" required name="password" placeholder="Password" required>
                            </label>
                            <br><br>
                            <label class="grid_4">
                                <a href="#" class="floatRight sh-clr">Forget Password?</a>
                            </label>
                            <br>
                            <div class="mgt_10 grid_4">
                                <button type="submit" class="mgl_5 btn">Login</button>
                            </div>
                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection