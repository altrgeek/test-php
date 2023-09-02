@extends('layouts.admin.app')

@section('content')
<div class="nk-content p-0">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-chat">
                <div class="nk-chat-aside">
                    <div class="nk-chat-aside-head">
                        <div class="nk-chat-aside-user">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle dropdown-indicator" data-toggle="dropdown">
                                    <div class="user-avatar">
                                        <img src="./images/avatar/b-sm.jpg" alt="">
                                    </div>
                                    <div class="title">Chats</div>
                                </a>
                                <div class="dropdown-menu">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="#"><span>Contacts</span></a></li>
                                        <li><a href="#"><span>Channels</span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><span>Help</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .nk-chat-aside-user -->
                        <ul class="nk-chat-aside-tools g-2">
                            <li>
                                <div class="dropdown">
                                    <a href="#" class="btn btn-round btn-icon btn-light dropdown-toggle" data-toggle="dropdown">
                                        <em class="icon ni ni-setting-alt-fill"></em>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="#"><span>Settings</span></a></li>
                                            <li class="divider"></li>
                                            <li><a href="#"><span>Message Requests</span></a></li>
                                            <li><a href="#"><span>Archives Chats</span></a></li>
                                            <li><a href="#"><span>Unread Chats</span></a></li>
                                            <li><a href="#"><span>Group Chats</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#" class="btn btn-round btn-icon btn-light">
                                    <em class="icon ni ni-edit-alt-fill"></em>
                                </a>
                            </li>
                        </ul><!-- .nk-chat-aside-tools -->
                    </div><!-- .nk-chat-aside-head -->
                    <div class="nk-chat-aside-body" data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: 0px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer">
                                </div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                        <div class="simplebar-content" style="padding: 0px;">
                                            <div class="nk-chat-aside-search">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-search"></em>
                                                        </div>
                                                        <input type="text" class="form-control form-round" id="default-03" placeholder="Search by name">
                                                    </div>
                                                </div>
                                            </div><!-- .nk-chat-aside-search -->
                                            <div class="nk-chat-aside-panel nk-chat-fav">
                                                <h6 class="title overline-title-alt">Favorites</h6>
                                                <ul class="fav-list">
                                                    <li>
                                                        <a href="#" class="btn btn-lg btn-icon btn-outline-light btn-white btn-round">
                                                            <em class="icon ni ni-plus"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="user-avatar">
                                                                <img src="./images/avatar/b-sm.jpg" alt="">
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="user-avatar">
                                                                <span>AB</span>
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="user-avatar bg-pink">
                                                                <span>KH</span>
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="user-avatar bg-purple">
                                                                <span>VB</span>
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="user-avatar">
                                                                <img src="./images/avatar/a-sm.jpg" alt="">
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="user-avatar">
                                                                <img src="./images/avatar/c-sm.jpg" alt="">
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="user-avatar">
                                                                <img src="./images/avatar/d-sm.jpg" alt="">
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="user-avatar bg-info">
                                                                <span>SK</span>
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul><!-- .fav-list -->
                                            </div><!-- .nk-chat-fav -->
                                            <div class="nk-chat-list">
                                                <h6 class="title overline-title-alt">Messages</h6>
                                                <ul class="chat-list">
                                                    <li class="chat-item">
                                                        <a class="chat-link chat-open" href="#">
                                                            <div class="chat-media user-avatar bg-purple">
                                                                <span>IH</span>
                                                                <span class="status dot dot-lg dot-gray"></span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Iliash Hossain</div>
                                                                    <span class="time">Now</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">
                                                                        <p>You: Please confrim if you got my last messages.</p>
                                                                    </div>
                                                                    <div class="status delivered">
                                                                        <em class="icon ni ni-check-circle-fill"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="chat-actions">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#">Mute</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Hide</a></li>
                                                                        <li><a href="#">Delete</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Mark as Unread</a></li>
                                                                        <li><a href="#">Ignore Messages</a></li>
                                                                        <li><a href="#">Block Messages</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li><!-- .chat-item -->
                                                    <li class="chat-item is-unread">
                                                        <a class="chat-link chat-open" href="#">
                                                            <div class="chat-media user-avatar">
                                                                <span>AB</span>
                                                                <span class="status dot dot-lg dot-gray"></span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Abu Bin Ishtiyak</div>
                                                                    <span class="time">4:49 AM</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">
                                                                        <p>Hi, I am Ishtiyak, can you help me with this problem ?</p>
                                                                    </div>
                                                                    <div class="status unread">
                                                                        <em class="icon ni ni-bullet-fill"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="chat-actions">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#">Mute</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Hide</a></li>
                                                                        <li><a href="#">Delete</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Mark as Unread</a></li>
                                                                        <li><a href="#">Ignore Messages</a></li>
                                                                        <li><a href="#">Block Messages</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li><!-- .chat-item -->
                                                    <li class="chat-item">
                                                        <a class="chat-link chat-open" href="#">
                                                            <div class="chat-media user-avatar">
                                                                <img src="./images/avatar/b-sm.jpg" alt="">
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">George Philips</div>
                                                                    <span class="time">6 Apr</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">
                                                                        <p>Have you seens the claim from Rose?</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="chat-actions">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#">Mute</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Hide</a></li>
                                                                        <li><a href="#">Delete</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Mark as Unread</a></li>
                                                                        <li><a href="#">Ignore Messages</a></li>
                                                                        <li><a href="#">Block Messages</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li><!-- .chat-item -->
                                                    <li class="chat-item">
                                                        <a class="chat-link chat-open" href="#">
                                                            <div class="chat-media user-avatar">
                                                                <img src="./images/avatar/a-sm.jpg" alt="">
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Larry Hughes</div>
                                                                    <span class="time">3 Apr</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">
                                                                        <p>Hi Frank! How is you doing?</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="chat-actions">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#">Mute</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Hide</a></li>
                                                                        <li><a href="#">Delete</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Mark as Unread</a></li>
                                                                        <li><a href="#">Ignore Messages</a></li>
                                                                        <li><a href="#">Block Messages</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li><!-- .chat-item -->
                                                    <li class="chat-item">
                                                        <a class="chat-link chat-open" href="#">
                                                            <div class="chat-media user-avatar">
                                                                <span>TW</span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Tammy Wilson</div>
                                                                    <span class="time">27 Mar</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">
                                                                        <p>You: I just bought a new computer but i am having some problem</p>
                                                                    </div>
                                                                    <div class="status sent">
                                                                        <em class="icon ni ni-check-circle"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="chat-actions">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#">Mute</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Hide</a></li>
                                                                        <li><a href="#">Delete</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Mark as Unread</a></li>
                                                                        <li><a href="#">Ignore Messages</a></li>
                                                                        <li><a href="#">Block Messages</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li><!-- .chat-item -->
                                                    <li class="chat-item">
                                                        <a class="chat-link chat-open" href="#">
                                                            <div class="chat-media user-avatar user-avatar-multiple">
                                                                <div class="user-avatar">
                                                                    <img src="./images/avatar/c-sm.jpg" alt="">
                                                                </div>
                                                                <div class="user-avatar">
                                                                    <span>AB</span>
                                                                </div>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Softnio Group</div>
                                                                    <span class="time">27 Mar</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">
                                                                        <p>You: I just bought a new computer but i am having some problem</p>
                                                                    </div>
                                                                    <div class="status sent">
                                                                        <em class="icon ni ni-check-circle"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="chat-actions">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#">Mute</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Hide</a></li>
                                                                        <li><a href="#">Delete</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Mark as Unread</a></li>
                                                                        <li><a href="#">Ignore Messages</a></li>
                                                                        <li><a href="#">Block Messages</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li><!-- .chat-item -->
                                                </ul><!-- .chat-list -->
                                            </div><!-- .nk-chat-list -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: auto; height: 664px;">
                            </div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                            <div class="simplebar-scrollbar" style="width: 0px; display: none;">
                            </div>
                        </div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                            <div class="simplebar-scrollbar" style="height: 130px; transform: translate3d(0px, 0px, 0px); display: block;">
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-chat-aside -->
                <div class="nk-chat-body">
                    <div class="nk-chat-head">
                        <ul class="nk-chat-head-info">
                            <li class="nk-chat-body-close">
                                <a href="#" class="btn btn-icon btn-trigger nk-chat-hide ml-n1"><em class="icon ni ni-arrow-left"></em></a>
                            </li>
                            <li class="nk-chat-head-user">
                                <div class="user-card">
                                    <div class="user-avatar bg-purple">
                                        <span>IH</span>
                                    </div>
                                    <div class="user-info">
                                        <div class="lead-text">Iliash Hossain</div>
                                        <div class="sub-text">
                                            <span class="d-none d-sm-inline mr-1">Active </span>
                                                35m ago
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="nk-chat-head-tools">
                            <li><a href="#" class="btn btn-icon btn-trigger text-primary"><em class="icon ni ni-call-fill"></em></a></li>
                            <li><a href="#" class="btn btn-icon btn-trigger text-primary"><em class="icon ni ni-video-fill"></em></a></li>
                            <li class="d-none d-sm-block">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger text-primary" data-toggle="dropdown"><em class="icon ni ni-setting-fill"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a class="dropdown-item" href="#"><em class="icon ni ni-archive"></em><span>Make as Archive</span></a></li>
                                            <li><a class="dropdown-item" href="#"><em class="icon ni ni-cross-c"></em><span>Remove Conversion</span></a></li>
                                            <li><a class="dropdown-item" href="#"><em class="icon ni ni-setting"></em><span>More Options</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="mr-n1 mr-md-n2"><a href="#" class="btn btn-icon btn-trigger text-primary chat-profile-toggle"><em class="icon ni ni-alert-circle-fill"></em></a></li>
                        </ul>
                        <div class="nk-chat-head-search">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-search"></em>
                                    </div>
                                    <input type="text" class="form-control form-round" id="chat-search" placeholder="Search in Conversation">
                                </div>
                            </div>
                        </div><!-- .nk-chat-head-search -->
                    </div><!-- .nk-chat-head -->
                    <div class="nk-chat-panel" data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: -20px -28px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer"></div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                        <div class="simplebar-content" style="padding: 20px 28px;">
                                            <div class="chat is-you">
                                                <div class="chat-avatar">
                                                    <div class="user-avatar bg-purple">
                                                        <span>IH</span>
                                                    </div>
                                                </div>
                                                <div class="chat-content">
                                                    <div class="chat-bubbles">
                                                        <div class="chat-bubble">
                                                            <div class="chat-msg"> Hello! </div>
                                                            <ul class="chat-msg-more">
                                                                <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="chat-bubble">
                                                            <div class="chat-msg"> I found an issues when try to purchase the product. </div>
                                                            <ul class="chat-msg-more">
                                                                <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="chat-meta">
                                                        <li>Iliash Hossain</li>
                                                        <li>29 Apr, 2020 4:28 PM</li>
                                                    </ul>
                                                </div>
                                            </div><!-- .chat -->
                                            <div class="chat is-me">
                                                <div class="chat-content">
                                                    <div class="chat-bubbles">
                                                        <div class="chat-bubble">
                                                            <div class="chat-msg"> Thanks for inform. We just solved the issues. Please check now. </div>
                                                            <ul class="chat-msg-more">
                                                                <li class="d-none d-sm-block">
                                                                    <a href="#" class="btn btn-icon btn-sm btn-trigger">
                                                                        <em class="icon ni ni-reply-fill"></em>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-sm">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="chat-meta">
                                                        <li>Abu Bin Ishtiyak</li>
                                                        <li>29 Apr, 2020 4:12 PM</li>
                                                    </ul>
                                                </div>
                                            </div><!-- .chat -->
                                            <div class="chat is-you">
                                                <div class="chat-avatar">
                                                    <div class="user-avatar bg-purple">
                                                        <span>IH</span>
                                                    </div>
                                                </div>
                                                <div class="chat-content">
                                                    <div class="chat-bubbles">
                                                        <div class="chat-bubble">
                                                            <div class="chat-msg"> This is really cool. </div>
                                                            <ul class="chat-msg-more">
                                                                <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="chat-bubble">
                                                            <div class="chat-msg"> It’s perfect. Thanks for letting me know. </div>
                                                            <ul class="chat-msg-more">
                                                                <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="chat-meta">
                                                        <li>Iliash Hossain</li>
                                                        <li>29 Apr, 2020 4:28 PM</li>
                                                    </ul>
                                                </div>
                                            </div><!-- .chat -->
                                            <div class="chat-sap">
                                                <div class="chat-sap-meta"><span>12 May, 2020</span></div>
                                            </div><!-- .chat-sap -->
                                            <div class="chat is-you">
                                                <div class="chat-avatar">
                                                    <div class="user-avatar bg-purple">
                                                        <span>IH</span>
                                                    </div>
                                                </div>
                                                <div class="chat-content">
                                                    <div class="chat-bubbles">
                                                        <div class="chat-bubble">
                                                            <div class="chat-msg"> Hey, I am facing problem as i can not login into application. Can you help me to reset my password? </div>
                                                            <ul class="chat-msg-more">
                                                                <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="chat-meta">
                                                        <li>3:49 PM</li>
                                                    </ul>
                                                </div>
                                            </div><!-- .chat -->
                                            <div class="chat is-me">
                                                <div class="chat-content">
                                                    <div class="chat-bubbles">
                                                        <div class="chat-bubble">
                                                            <div class="chat-msg"> Definately. We are happy to help you. </div>
                                                            <ul class="chat-msg-more">
                                                                <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-sm">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="chat-meta">
                                                        <li>3:55 PM</li>
                                                    </ul>
                                                </div>
                                            </div><!-- .chat -->
                                            <div class="chat is-you">
                                                <div class="chat-avatar">
                                                    <div class="user-avatar bg-purple">
                                                        <span>IH</span>
                                                    </div>
                                                </div>
                                                <div class="chat-content">
                                                    <div class="chat-bubbles">
                                                        <div class="chat-bubble">
                                                            <div class="chat-msg"> Thank you! Let me know when it done. </div>
                                                            <ul class="chat-msg-more">
                                                                <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                <li>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="chat-meta">
                                                        <li>3:49 PM</li>
                                                    </ul>
                                                </div>
                                            </div><!-- .chat -->
                                            {{-- @foreach ($messages as $message) --}}
                                                <div class="chat is-me">
                                                    <div class="chat-content">
                                                        <div class="chat-bubbles">
                                                            <div class="chat-bubble">
                                                                <div class="chat-msg"></div>
                                                                <ul class="chat-msg-more">
                                                                    <li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>
                                                                    <li>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-sm">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li class="d-sm-none"><a href="#"><em class="icon ni ni-reply-fill"></em> Reply</a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-pen-alt-fill"></em> Edit</a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-trash-fill"></em> Remove</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <ul class="chat-meta">
                                                            <li><span>Now</span> <em class="icon ni ni-check-circle-fill"></em></li>
                                                        </ul>
                                                    </div>
                                                </div><!-- .chat -->
                                            {{-- @endforeach --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: auto; height: 776px;">
                            </div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                            <div class="simplebar-scrollbar" style="width: 0px; display: none;">
                            </div>
                        </div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                            <div class="simplebar-scrollbar" style="height: 65px; transform: translate3d(0px, 0px, 0px); display: block;">
                            </div>
                        </div>
                    </div><!-- .nk-chat-panel -->
                    <form
                        id="chatForm">
                        @csrf

                        <div id="errors">
                        </div>

                        <div class="nk-chat-editor">
                            <div class="nk-chat-editor-upload  ml-n1">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger text-primary toggle-opt" data-target="chat-upload"><em class="icon ni ni-plus-circle-fill"></em></a>
                                <div class="chat-upload-option" data-content="chat-upload">
                                    <ul class="">
                                        <li><a href="#"><em class="icon ni ni-img-fill"></em></a></li>
                                        <li><a href="#"><em class="icon ni ni-camera-fill"></em></a></li>
                                        <li><a href="#"><em class="icon ni ni-mic"></em></a></li>
                                        <li><a href="#"><em class="icon ni ni-grid-sq"></em></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="nk-chat-editor-form">
                                <div class="form-control-wrap">
                                    <textarea class="form-control form-control-simple no-resize" rows="1" id="message-textarea" placeholder="Type your message..."></textarea>
                                </div>
                            </div>
                            <ul class="nk-chat-editor-tools g-2">
                                <li>
                                    <a href="#" class="btn btn-sm btn-icon btn-trigger text-primary"><em class="icon ni ni-happyf-fill"></em></a>
                                </li>
                                <li>
                                    <button type="submit" class="btn btn-round btn-primary btn-icon"><em class="icon ni ni-send-alt"></em></button>
                                </li>
                            </ul>
                        </div><!-- .nk-chat-editor -->
                    </form>
                </div>
                <div class="nk-chat-profile" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: 0px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer">
                            </div>
                        </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                        <div class="simplebar-content" style="padding: 0px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="user-card user-card-s2 my-4">
                            <div class="user-avatar md bg-purple">
                                <span>IH</span>
                            </div>
                            <div class="user-info">
                                <h5>Iliash Hossain</h5>
                                <span class="sub-text">Active 35m ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<x-slot name="scripts">
    @section('scripts')
    @endsection
</x-slot>
