@extends('layouts.emails.master')

@section('content')
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">

                <table role="presentation" class="main">

                    <tr>
                        <td class="wrapper">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>

                                        @include('layouts.emails.includes.header')

                                        @if(isset($callToAction))
                                        @include('layouts.emails.includes.button')
                                        @endif

                                        <hr>
                                        <p>
                                            <strong>Name: </strong>
                                            {{ $name ?? '' }}
                                        </p>
                                        <p>
                                            <strong>Email: </strong>
                                            {{ $email ?? '' }}
                                        </p>
                                        <p>
                                            <strong>Message: </strong>
                                            {{ nl2br($comment) ?? '' }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>

                @include('layouts.emails.includes.footer')

            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
@endsection