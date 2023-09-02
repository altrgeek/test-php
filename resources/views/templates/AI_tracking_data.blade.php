
@extends('layouts.admin.app')

@section('content')

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Psychosocial Treatment</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                                <button type="button" class="btn btn-white btn-dim btn-outline-light" data-toggle="modal" data-target="#addTherapies"><em class="icon ni ni-plus"></em><span>Create New Treatment</span></button>
                          
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-xxl-12">
                            <div class="col-12 div_alert">
                              </div>
                            <table class="datatable-init  nk-tb-list is-separate dataTable no-footer" data-auto-responsive="false" id="DataTables_Table_2"  aria-describedby="DataTables_Table_2_info">
                                <thead>
                                    <tr class="nk-tb-item nk-tb-head" role="row">
                                        <th class="nk-tb-col sorting" ><span>Exposure therapy</span></th>
                                        <th class="nk-tb-col  sorting" ><span>Description</span></th>
                                        <th class="nk-tb-col  sorting" ><span>Marketplace of Therapy and Counselling</span></th>
                                        <th class="nk-tb-col  sorting" ><span>Time</span></th>
                                        <th class="nk-tb-col  sorting" ><span>Providers who offer treatment</span></th>
                                        <th class="nk-tb-col  sorting" ><span>Prompt</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="nk-tb-item odd">
                                        <td class="nk-tb-col"><span class="tb-lead">Exposure Therapy</span></td>
                                        <td class="nk-tb-col " ><span class="tb-product">
                                            Usually used to treat anxiety disorders, this type of therapy involves having the individual expose him.......
                                        </span></td>
                                        <td class="nk-tb-col">
                                            <span class="badge bg-lighter ">Circles of my life</span>
                                            <span class="badge bg-lighter ">Searching I AM</span>
                                            <span class="badge bg-lighter "> Overcoming your Fears and achieve Breakthroughs</span>
                                           
                                        </td>
                                        <td class="nk-tb-col"><span class="tb-lead">30 mints</span></td>
                                        <td class="nk-tb-col"><span class="tb-lead">Exposure Therapy</span></td>
                                        <td class="nk-tb-col">
                                            <span class="tb-lead text-center">
                                                <a href="#" type="button" data-toggle="modal" data-target="#modalDefault"><em class="icon ni ni-eye " style="font-size: 25px;"></em></a> 
                                            </span>
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#" data-toggle="modal" data-target="#EditTherapies"><em class="icon ni ni-edit" ></em><span>Edit</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-delete"></em><span>Delete</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </td>
                                    </tr> 
                                    <tr class="nk-tb-item odd">
                                        <td class="nk-tb-col"><span class="tb-lead">Exposure Therapy</span></td>
                                        <td class="nk-tb-col " ><span class="tb-product">
                                            Usually used to treat anxiety disorders, this type of therapy involves having the individual expose him.......
                                        </span></td>
                                        <td class="nk-tb-col">
                                            <span class="badge bg-lighter ">Circles of my life</span>
                                            <span class="badge bg-lighter ">Searching I AM</span>
                                            <span class="badge bg-lighter "> Overcoming your Fears and achieve Breakthroughs</span>
                                           
                                        </td>
                                        <td class="nk-tb-col"><span class="tb-lead">30 mints</span></td>
                                        <td class="nk-tb-col"><span class="tb-lead">Exposure Therapy</span></td>
                                        <td class="nk-tb-col">
                                            <span class="tb-lead text-center">
                                                <a href="#" type="button" data-toggle="modal" data-target="#modalDefault"><em class="icon ni ni-eye " style="font-size: 25px;"></em></a> 
                                            </span>
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#" data-toggle="modal" data-target="#EditTherapies"><em class="icon ni ni-edit" ></em><span>Edit</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-delete"></em><span>Delete</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </td>
                                    </tr>
                                    <tr class="nk-tb-item odd">
                                        <td class="nk-tb-col"><span class="tb-lead">Exposure Therapy</span></td>
                                        <td class="nk-tb-col " ><span class="tb-product">
                                            Usually used to treat anxiety disorders, this type of therapy involves having the individual expose him.......
                                        </span></td>
                                        <td class="nk-tb-col">
                                            <span class="badge bg-lighter ">Circles of my life</span>
                                            <span class="badge bg-lighter ">Searching I AM</span>
                                            <span class="badge bg-lighter "> Overcoming your Fears and achieve Breakthroughs</span>
                                           
                                        </td>
                                        <td class="nk-tb-col"><span class="tb-lead">30 mints</span></td>
                                        <td class="nk-tb-col"><span class="tb-lead">Exposure Therapy</span></td>
                                        <td class="nk-tb-col">
                                            <span class="tb-lead text-center">
                                                <a href="#" type="button" data-toggle="modal" data-target="#modalDefault"><em class="icon ni ni-eye " style="font-size: 25px;"></em></a> 
                                            </span>
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#" data-toggle="modal" data-target="#EditTherapies"><em class="icon ni ni-edit" ></em><span>Edit</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-delete"></em><span>Delete</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </td>
                                    </tr>
                                    <tr class="nk-tb-item odd">
                                        <td class="nk-tb-col"><span class="tb-lead">Exposure Therapy</span></td>
                                        <td class="nk-tb-col " ><span class="tb-product">
                                            Usually used to treat anxiety disorders, this type of therapy involves having the individual expose him.......
                                        </span></td>
                                        <td class="nk-tb-col">
                                            <span class="badge bg-lighter ">Circles of my life</span>
                                            <span class="badge bg-lighter ">Searching I AM</span>
                                            <span class="badge bg-lighter "> Overcoming your Fears and achieve Breakthroughs</span>
                                           
                                        </td>
                                        <td class="nk-tb-col"><span class="tb-lead">30 mints</span></td>
                                        <td class="nk-tb-col"><span class="tb-lead">Exposure Therapy</span></td>
                                        <td class="nk-tb-col">
                                            <span class="tb-lead text-center">
                                                <a href="#" type="button" data-toggle="modal" data-target="#modalDefault"><em class="icon ni ni-eye " style="font-size: 25px;"></em></a> 
                                            </span>
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#" data-toggle="modal" data-target="#EditTherapies"><em class="icon ni ni-edit" ></em><span>Edit</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-delete"></em><span>Delete</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                      
                        </div><!-- .col -->
                    </div><!-- .row -->




                    
                    

                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>

@endsection