@extends('layout.master')

@section('title') TWS | Profile @endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="profile-container">
    <div class="profile-content">
        <div class="profile">
            @if ($users->image == NULL)
                <img src="{{ asset('images/profile.png') }}">
            @else
                <img src="{{ asset('images-upload/' . $users->image) }}">
            @endif   
            <div class="camera">
                <i class="fas fa-camera"></i>
            </div>
        </div>
        <p class="fullname"> {{ $users->name }} </p>
        <p> <span> Username: </span> {{ $users->username }} </p>
        <p> <span> Email: </span> {{ $users->email }} </p>
        <button id="change-password-button" type="submit"> Change Password </button>
        <div class="password-container" 
            @error('current_password')
                style="display: block; background-color: red"
            @enderror>
            <div class="btn-save-password">
                <form action="{{ route('profile', $users->id) }}" method="POST">
                    @csrf
                    @error('current_password')
                        <div class="error-container">
                            {{ session('password-error') }}
                        </div>
                    @enderror
                    <input type="password" name="current_password" placeholder="Current Password">
                    <input type="password" name="password" placeholder="New Password">
                    <input type="password" name="password_confirmation" placeholder="Repeat new Password">
                    <input type="submit" name="submit" value="Save">
                    <input type="submit" id="cancel-button" value="Cancel">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="change-picture-container">
    <div class="exit">
        <i class="fas fa-times"></i>
    </div>
    <form action="{{ route('profile', $users->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="profile-preview">
            @if ($users->image == NULL)
                <img id="profile-prev" src="{{ asset('images/profile.png') }}">
            @else
                <img id="profile-prev" src="{{ asset('images-upload/' . $users->image) }}">
            @endif
        </div>
        <div class="btn-change-profile">
            <input type="file" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
            <input type="file" name="image" id="file" accept="image/*" onchange="showPreview(event);">
            <label for="file"> Choose Profile </label>
        </div>
        <div class="btn-save-profile">
            <input type="submit" name="submit" value="Save">
            <input type="submit" id="cancel" value="Cancel">
        </div>
    </form>
</div>


    <script>
        // For camera icon
        let btnCamera = document.querySelector(".camera");

        let profileCon = document.querySelector(".profile-container");
        let changePictureCon = document.querySelector(".change-picture-container");
        let btnExit = document.querySelector(".exit");

        btnCamera.addEventListener('click', function(){
            changePictureCon.style.display = "block";
            profileCon.style.opacity = ".2";
        });

        btnExit.addEventListener('click', function(){
            changePictureCon.style.display = "none";
            profileCon.style.opacity = "1";
        });
        // For camera icon

        // For change profile container
        let btnChangeProfile = document.querySelector(".btn-change-profile");
        let btnSaveProfile = document.querySelector(".btn-save-profile");
        let btnCancel = document.getElementById("cancel");

        function showPreview(event){
            if(event.target.files.length > 0){
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("profile-prev");
                preview.src = src;
                btnChangeProfile.style.display = "none";
                btnSaveProfile.style.display = "flex";
            }
        }

        btnCancel.addEventListener('click', function(e){
            e.preventDefault();
            btnSaveProfile.style.display = "none";
            btnChangeProfile.style.display = "flex";
            window.location.reload();
        });
        // For change profile container

        // For change password container
        let changePasswordBtn = document.getElementById("change-password-button");
        let savehangePasswordBtn = document.getElementById("save-password-button");
        let changePasswordCon = document.querySelector(".password-container");

        changePasswordBtn.addEventListener('click', function(){
            changePasswordBtn.style.display = "none";
            changePasswordCon.style.display = "flex";
        });

        let btnCancelPassword = document.getElementById("cancel-button");

        btnCancelPassword.addEventListener('click', function(e){
            e.preventDefault();
            changePasswordCon.style.display = "none";
            changePasswordBtn.style.display = "flex";
        });
        // For change password container

    </script>

@endsection