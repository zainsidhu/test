@extends('layout.master')

@section('content')

    <section class="well1 ins2 mobile-center">
        <div class="container">
            @if(count($category)>0)
                @foreach($category as $key => $value)
                    <div class="grid_4">
                        <h6 class="subHeadingBackground w-clr pdl_20 pdt_5 pdb_5">{{$category[0]['name']}}</h6>
                        <div class="row off2">
                            <div class="grid_8 content justify">
                                @foreach($category[$key]['programs'] as $program)
                                    <div class=" mgt_20">
                                        <h3 class="h-clr boldText">{{$program->program_name}}</h3>
                                        <p class="p-clr">{!! $program->content !!} </p><br>
                                        <p><strong>Class Detail</strong></p>
                                        <div>
                                            @foreach($program->classes as $class)
                                                @if($class->price_type == 'SP')
                                                    <div class="mgt_10 grid_8 classBackgroud mgl_5 alignCenterVertical pd_20">
                                                        <div class="grid_5 mgl_5 mgb_20">
                                                            <strong><p class="mgl_10 mgt_20 p-clr">{{$class->class_name}}</p></strong>

                                                            @if($class->class_from_date!='' && $class->class_to_date!='' )
                                                                <div>
                                                                    <span class="mgl_10 sh-clr fontSizeSmall"><strong>{{date('d/m/Y', strtotime($class->class_from_date)).' - '.date('d/m/Y', strtotime($class->class_to_date))}}</strong></span>
                                                                </div>
                                                            @endif

                                                            @if($class->dates!='')
                                                                <div>
                                                                    <?php $datesArr = explode('|', $class->dates)?>
                                                                    @if($datesArr[1]!='0' && $datesArr[1]!=0)

                                                                        <span class="mgl_10 sh-clr fontSizeSmall">{{$datesArr[0].' '.$datesArr[1].' - '.$datesArr[2]}}</span>
                                                                    @else

                                                                        <span class="mgl_10 sh-clr fontSizeSmall">{{$datesArr[0].' '.$datesArr[2].' - '.$datesArr[3]}}</span>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                            @if($class->teacher != '' && count((new \App\Teacher())->getTeacherByID($class->teacher))>0)

                                                                @if((new \App\Teacher())->getTeacherByID($class->teacher)->first_name != '')
                                                                    <div>
                                                                        <span class="mgl_10 p-clr fontSizeSmall"><strong>Teacher: </strong></span>
                                                                        <span class=" p-clr fontSizeSmall">{{(new \App\Teacher())->getTeacherByID($class->teacher)->first_name}}</span>
                                                                    </div>
                                                                @endif

                                                            @endif

                                                            @if($class->address!='' || $class->city)
                                                                <div>
                                                                    <p class="mgl_10 p-clr fontSizeSmall">{{$class->address.','}}</p>
                                                                    <p class="mgl_10 p-clr fontSizeSmall">{{$class->city}}</p>
                                                                </div>
                                                            @endif

                                                        </div>
                                                        @if($class->early_bird_price != '')
                                                            <div class="grid_3 mgl_20 alignCenter mgt_20 mgb_20 pdb_10">
                                                                <div class="earlyBirdBackround floatRight">
                                                                    <h4 class="h-clr boldText">Early Bird Price</h4>
                                                                    <div>
                                                                        <h2 class="mgt_5 h-clr boldText">${{$class->early_bird_price}}</h2>
                                                                        <div class="">
                                                                            <span class="p-clr">Normal Price: </span>
                                                                            <span class="p-clr fontSizeLarge"><strike>${{$class->price}}</strike></span>
                                                                        </div>
                                                                    </div>
                                                                    <form method="post" action="{{route('post-checkout')}}">
                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                        <input type="hidden" name="class_id" value="{{$class->id}}">
                                                                        <input type="hidden" name="program_id" value="{{$program->id}}">
                                                                        <input type="hidden" name="price" value="{{$class->early_bird_price}}">
                                                                    <button type="submit" class="mgt_5 btn">Sign Up Now</button>
                                                                    </form>
                                                                </div>
                                                                @if($class->early_bird_date1 != '')
                                                                    <p class="p-clr boldText">Hurry Up! Early Bird Ends on:</p>
                                                                    <p class="p-clr boldText">{{date('d/m', strtotime($class->early_bird_date1))}}</p>
                                                                @endif

                                                                <div class="clearfix"></div>
                                                            </div>
                                                        @else
                                                            <div class="grid_5 mgl_20 alignCenter mgt_20 mgb_20">
                                                                <form method="post" action="{{route('post-checkout')}}">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="hidden" name="class_id" value="{{$class->id}}">
                                                                    <input type="hidden" name="program_id" value="{{$program->id}}">
                                                                    <input type="hidden" name="price" value="{{$class->price}}">
                                                                @if($class->price != '')
                                                                    <h1 class="h-clr boldText">${{$class->price}}</h1>
                                                                @endif
                                                                <button type="submit" class="mgt_5 btn">Sign Up Now</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif($class->price_type == 'PP' && $class->pp_val != '')
                                                    @if(unserialize($class->pp_val))
                                                        <?php $PPArr = unserialize(stripslashes($class->pp_val));?>
                                                    @else
                                                        <?php $PPArr = array(stripslashes($class->pp_val));?>
                                                    @endif

                                                    <div class="mgt_10 grid_8 classBackgroud mgl_5 alignCenterVertical">
                                                        <div class="grid_3 mgl_5 mgb_20 p-clr">
                                                            <strong><p class="mgl_10 mgt_20">{{$class->class_name}}</p></strong>
                                                        </div>

                                                        <div class="grid_5 alignCenter mgt_20 mgb_20">
                                                            <form method="post" action="{{route('post-checkout')}}">
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
                                                            </form>
                                                        </div>
                                                    </div>
                                                @elseif($class->price_type == 'PL' && $class->pp_val != '')
                                                    <div class="mgt_10 grid_8 classBackgroud mgl_5 alignCenterVertical">
                                                        <div class="grid_5 mgl_10 mgl_5 mgb_20">
                                                            <strong><p class="mgl_10 mgt_20 p-clr">{{$class->class_name}}</p></strong>
                                                            @if($class->class_from_date!='' && $class->class_from_date!='00/00/00')
                                                                <div>
                                                                    <span class="mgl_10 p-clr fontSizeSmall">Date: </span>
                                                                    <span class="sh-clr fontSizeSmall"><strong>{{date('d/m/Y', strtotime($class->class_from_date))}}</strong></span>
                                                                </div>
                                                            @endif

                                                            @if($class->class_time!='')
                                                                <div>
                                                                    <span class="mgl_10 p-clr fontSizeSmall"><strong>Time: </strong></span>
                                                                    <?php $classTimeArr = explode('~', $class->class_time)?>
                                                                    <span class="p-clr fontSizeSmall">{{$classTimeArr[0].' - '.$classTimeArr[1]}}</span>
                                                                </div>
                                                            @endif


                                                            @if($class->address!='' || $class->city)
                                                                <div>
                                                                    <p class="mgl_10 p-clr fontSizeSmall">{{$class->address.','}}</p>
                                                                    <p class="mgl_10 p-clr fontSizeSmall">{{$class->city}}</p>
                                                                </div>
                                                            @endif

                                                        </div>
                                                        <div class="grid_5 alignCenter mgt_20 mgb_20">
                                                            <a href=" {{$class->pp_val}}" class="h-clr"><strong>More Details</strong></a>
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
                @endforeach
            @endif
        </div>
    </section>

@endsection
