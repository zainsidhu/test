@extends('layout.master')

@section('content')

    <section class="well1 ins2 mobile-center">
        <div class="container">
            <div class="grid_8">
                <h6 class="subHeadingBackground w-clr pdl_20 pdt_5 pdb_5">{{$programs[0]->category->category_name}}</h6>
                <div class="row off2">
                    <div class="grid_8 content justify">
                        @foreach($programs as $program)
                            <div class=" mgt_20">
                                <h3 class="h-clr boldText">{{$program->program_name}}</h3>
                                <p class="p-clr">{!! $program->content !!} </p><br>
                                <p><strong>Class Detail</strong></p>
                                <div>
                                    @foreach($program->classes as $class)
                                        @if($class->price_type == 'SP')
                                        <div class="mgt_10 grid_8 classBackgroud mgl_5 pd_10 alignCenterVertical">
                                            <div class="grid_3 mgl_5 mgb_20">
                                                <strong><p class="mgl_10 mgt_20 p-clr">{{$class->class_name}}</p></strong>
                                                @if($class->price!='')<p class="mgl_10">${{$class->price}} {{$class->duration_private_class}}</p>@endif
                                            </div>
                                            <div class="grid_5 mgl_20 alignCenter mgt_20 mgb_20">
                                                    @if($class->price!='')<h1 class="h-clr boldText">${{$class->price}}</h1>@endif
                                                    <form method="post" action="{{route('post-checkout')}}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="class_id" value="{{$class->id}}">
                                                        <input type="hidden" name="program_id" value="{{$program->id}}">
                                                        <input type="hidden" name="price" value="{{$class->price}}">
                                                    <button type="submit" class="mgt_5 btn">Sign Up Now</button>
                                                    </form>
                                            </div>
                                        </div>
                                        @elseif($class->price_type == 'PP' && $class->pp_val != '')
                                            @if(unserialize($class->pp_val))
                                                <?php $PPArr = unserialize(stripslashes($class->pp_val));?>
                                            @else
                                                <?php $PPArr = array(stripslashes($class->pp_val));?>
                                            @endif

                                                <div class="mgt_10 grid_8 classBackgroud mgl_5 pd_10 alignCenterVertical">
                                                    <div class="grid_3 mgl_5 mgb_20">
                                                        <strong><p class="mgl_10 mgt_20 p-clr">{{$class->class_name}}</p></strong>
                                                 </div>

                                                    <form method="post" action="{{route('post-checkout')}}">
                                                        <div class="grid_5 alignCenter mgt_20 mgb_20">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="class_id" value="{{$class->id}}">
                                                            <input type="hidden" name="program_id" value="{{$program->id}}">
                                                            @foreach($PPArr as $key => $value)
                                                                <div class="floatLeft classPriceLeftMargin">

                                                                    <input type="radio" name="price" id="Chk_PPArrId{{$class->id}}" value="{{$PPArr[$key]['PP_Rate']}}" @if($key==0) checked="checked" @endif/>${{number_format($PPArr[$key]['PP_Rate'], '0', '.', '').' for '.$PPArr[$key]['PP_NumSession'].' Session'}}
                                                                    @if($PPArr[$key]['PP_Saving'] != '' && $PPArr[$key]['PP_Saving'] > 0)
                                                                        {{'(Save:'.$PPArr[$key]['PP_Saving'].')'}}
                                                                    @endif

                                                                </div>
                                                                <br>
                                                            @endforeach
                                                            <button type="submit" class="mgt_5 btn">Sign Up Now</button>
                                                        </div>
                                                    </form>
                                                </div>
                                        @elseif($class->price_type == 'PL' && $class->pp_val != '')
                                            <div class="mgt_10 grid_8 classBackgroud mgl_5 pd_10 alignCenterVertical">
                                                <div class="grid_3 mgl_5 mgb_20">
                                                    <strong><p class="mgl_10 mgt_20 p-clr">{{$class->class_name}}</p></strong>
                                                </div>
                                                <div class="grid_5 mgl_20 alignCenter mgt_20 mgb_20">
                                                    <a href=" {{$class->pp_val}}" target="_blank" class="darkpink"><strong>More Details</strong></a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr class="headingHeight"><br>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection