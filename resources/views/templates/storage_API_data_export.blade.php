@extends('layouts.admin.app')

@section('content')

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Storage | Archives</h3>
                          </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <a href="#" class="btn btn-white btn-dim btn-outline-light" data-toggle="modal" data-target="#addEventPopup"><em class="icon ni ni-plus"></em><span>Add Files</span></a>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->

                <div class="toggle-expand-content expanded" data-content="quick-access">
                    <div class="nk-files nk-files-view-grid">
                        <div class="nk-files-list">
                            <div class="nk-file-item nk-file">
                                <div class="nk-file-info">
                                    <a href="#" class="nk-file-link">
                                        <div class="nk-file-title">
                                            <div class="nk-file-icon">
                                                <span class="nk-file-icon-type">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                        <g>
                                                            <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611"></rect>
                                                            <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c"></path>
                                                            <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="nk-file-name">
                                                <div class="nk-file-name-text">
                                                    <h5 class="title">UI Design</h5>
                                                </div>
                                                <p style="font-size: 12px;">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, nisi placeat illum in provident fuga id! Tenetur temporibus explicabo soluta assumenda culpa libero tempore. Ex ipsum consequuntur fugiat consequatur molestiae.
                                                </p>
                                                <a href="#" class="btn btn-primary mt-3">Transfer File</a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="nk-file-actions hideable">
                                    <a href="#" class="btn btn-sm btn-icon btn-trigger"><em class="icon ni ni-cross"></em></a>
                                </div>
                            </div>
                            <div class="nk-file-item nk-file">
                                <div class="nk-file-info">
                                    <a href="#" class="nk-file-link">
                                        <div class="nk-file-title">
                                            <div class="nk-file-icon">
                                                <span class="nk-file-icon-type">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                        <g>
                                                            <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611"></rect>
                                                            <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c"></path>
                                                            <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="nk-file-name">
                                                <div class="nk-file-name-text">
                                                    <h5 class="title"> Resource</h5>
                                                </div>
                                                <p style="font-size: 12px;">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, nisi placeat illum in provident fuga id! Tenetur temporibus explicabo soluta assumenda culpa libero tempore. Ex ipsum consequuntur fugiat consequatur molestiae.
                                                </p>
                                                <a href="#" class="btn btn-primary mt-3">Transfer File</a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="nk-file-actions hideable">
                                    <a href="#" class="btn btn-sm btn-icon btn-trigger"><em class="icon ni ni-cross"></em></a>
                                </div>
                            </div>
                            <div class="nk-file-item nk-file">
                                <div class="nk-file-info">
                                    <a href="#" class="nk-file-link">
                                        <div class="nk-file-title">
                                            <div class="nk-file-icon">
                                                <span class="nk-file-icon-type">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                        <g>
                                                            <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611"></rect>
                                                            <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c"></path>
                                                            <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="nk-file-name">
                                                <div class="nk-file-name-text">
                                                    <h5 class="title">Projects</h5>
                                                </div>
                                                <p style="font-size: 12px;">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, nisi placeat illum in provident fuga id! Tenetur temporibus explicabo soluta assumenda culpa libero tempore. Ex ipsum consequuntur fugiat consequatur molestiae.
                                                </p>
                                                <a href="#" class="btn btn-primary mt-3">Transfer File</a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="nk-file-actions hideable">
                                    <a href="#" class="btn btn-sm btn-icon btn-trigger"><em class="icon ni ni-cross"></em></a>
                                </div>
                            </div>
                            <div class="nk-file-item nk-file">
                                <div class="nk-file-info">
                                    <a href="#" class="nk-file-link">
                                        <div class="nk-file-title">
                                            <div class="nk-file-icon">
                                                <span class="nk-file-icon-type">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                        <g>
                                                            <rect x="18" y="16" width="36" height="40" rx="5" ry="5" style="fill:#e3edfc"></rect>
                                                            <path d="M19.03,54A4.9835,4.9835,0,0,0,23,56H49a4.9835,4.9835,0,0,0,3.97-2Z" style="fill:#c4dbf2"></path>
                                                            <rect x="32" y="20" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4"></rect>
                                                            <rect x="32" y="25" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4"></rect>
                                                            <rect x="32" y="30" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4"></rect>
                                                            <rect x="32" y="35" width="8" height="2" rx="1" ry="1" style="fill:#7e95c4"></rect>
                                                            <path d="M35,16.0594h2a0,0,0,0,1,0,0V41a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V16.0594A0,0,0,0,1,35,16.0594Z" style="fill:#7e95c4"></path>
                                                            <path d="M38.0024,40H33.9976A1.9976,1.9976,0,0,0,32,41.9976v2.0047A1.9976,1.9976,0,0,0,33.9976,46h4.0047A1.9976,1.9976,0,0,0,40,44.0024V41.9976A1.9976,1.9976,0,0,0,38.0024,40Zm-.0053,4H34V42h4Z" style="fill:#7e95c4"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="nk-file-name">
                                                <div class="nk-file-name-text">
                                                    <h5 class="title">All work.zip</h5>
                                                </div>
                                                <p style="font-size: 12px;">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, nisi placeat illum in provident fuga id! Tenetur temporibus explicabo soluta assumenda culpa libero tempore. Ex ipsum consequuntur fugiat consequatur molestiae.
                                                </p>
                                                <a href="#" class="btn btn-primary mt-3">Transfer File</a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="nk-file-actions hideable">
                                    <a href="#" class="btn btn-sm btn-icon btn-trigger"><em class="icon ni ni-cross"></em></a>
                                </div>
                            </div>
                            <div class="nk-file-item nk-file">
                                <div class="nk-file-info">
                                    <a href="#" class="nk-file-link">
                                        <div class="nk-file-title">
                                            <div class="nk-file-icon">
                                                <span class="nk-file-icon-type">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
                                                        <path d="M49,61H23a5.0147,5.0147,0,0,1-5-5V16a5.0147,5.0147,0,0,1,5-5H40.9091L54,22.1111V56A5.0147,5.0147,0,0,1,49,61Z" style="fill:#e3edfc"></path>
                                                        <path d="M54,22.1111H44.1818a3.3034,3.3034,0,0,1-3.2727-3.3333V11s1.8409.2083,6.9545,4.5833C52.8409,20.0972,54,22.1111,54,22.1111Z" style="fill:#b7d0ea"></path>
                                                        <path d="M19.03,59A4.9835,4.9835,0,0,0,23,61H49a4.9835,4.9835,0,0,0,3.97-2Z" style="fill:#c4dbf2"></path>
                                                        <path d="M42,31H30a3.0033,3.0033,0,0,0-3,3V45a3.0033,3.0033,0,0,0,3,3H42a3.0033,3.0033,0,0,0,3-3V34A3.0033,3.0033,0,0,0,42,31ZM29,38h6v3H29Zm8,0h6v3H37Zm6-4v2H37V33h5A1.001,1.001,0,0,1,43,34ZM30,33h5v3H29V34A1.001,1.001,0,0,1,30,33ZM29,45V43h6v3H30A1.001,1.001,0,0,1,29,45Zm13,1H37V43h6v2A1.001,1.001,0,0,1,42,46Z" style="fill:#36c684"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="nk-file-name">
                                                <div class="nk-file-name-text">
                                                    <h5 class="title">Sales Reports.xlsx</h5>
                                                </div>
                                                <p style="font-size: 12px;">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, nisi placeat illum in provident fuga id! Tenetur temporibus explicabo soluta assumenda culpa libero tempore. Ex ipsum consequuntur fugiat consequatur molestiae.
                                                </p>
                                                <a href="#" class="btn btn-primary mt-3">Transfer File</a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="nk-file-actions hideable">
                                    <a href="#" class="btn btn-sm btn-icon btn-trigger"><em class="icon ni ni-cross"></em></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- .nk-files -->
                </div>


        
    </div>
</div>
</div>
</div>

<div class="modal fade" id="addEventPopup">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Add Files</h5>
        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
        </a>
    </div>
    <div class="modal-body">
        <form action="#" id="addEventForm" class="form-validate is-alter">
            <div class="row gx-4 gy-3">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label" for="default-01">Title</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="default-01" placeholder="Input Title">
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label" for="default-01">Discription</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="default-01" placeholder="Input placeholder">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label" for="default-06">Default File Upload</label>
                        <div class="form-control-wrap">
                            <div class="custom-file">
                                <input type="file" multiple="" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="col-12">
                    <ul class="d-flex justify-content-between gx-4 mt-1">
                        <li class="">
                            <button id="addEvent" type="submit" class="btn btn-primary">Add Booking</button>
                        </li>
                    </ul>
                </div> 
            </div>
        </form>
    </div>
</div>
</div>
</div>

@endsection