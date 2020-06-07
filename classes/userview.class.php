<?php

class UserView {
    public function register() {
      $view =
      '<form action="#" enctype="multipart/form-data" method="post">
        <div class="form-row">
          <div class="col">
            <input class="form-control" type="text" placeholder="Username" id="username" name="username" aria-label="Search">
          </div>
          <div class="col">
            <input class="form-control" type="email" placeholder="Email" id="Email" name="email" aria-label="Email">
          </div>
        </div>
        <div class="form-row mt-1">
          <div class="col">
            <input class="form-control" type="password" placeholder="Password" id="passwd" name="passwd" aria-label="Password">
          </div>
          <div class="col">
            <input class="form-control" type="password" placeholder="Repeat Password" id="passwdrpt" name="passwdrpt" aria-label="Repeat Password">
          </div>
        </div>
        <div class="form-row justify-content-center">
          <div class="col-1 mt-1">
            <button class="btn btn-primary" type="submit">Register</button>
          </div>
        </div>
      </form>';

      echo $view;
    }

    public function registerSuccess($name, $email) {
      $view =
      '<div class="row justify-content-center text-center">
        <div class="col">Registration successfull!</div>
      </div>
      <div class="row justify-content-center text-center">
        <div class="col">Welcome to the Simracersworld Championship Management System, '.$name.'</div>
      </div>
      <div class="row justify-content-center text-center">
        <div class="col">We did not send anything to your email '.$email.' ...yet.</div>
      </div>';

      echo $view;
    }

    public function loginSuccess() {
      $view =
      '<div class="jumbotron">
        <div class="row justify-content-center text-center">
          <div class="col">Login successfull!</div>
        </div>
      </div>';

      echo $view;
    }

    public function loginFail() {
      $view =
      '<div class="jumbotron">
        <div class="row justify-content-center text-center">
          <div class="col">Wrong username or password.</div>
        </div>
      </div>';

      echo $view;
    }

    public function loggedOut() {
      $view =
      '<div class="jumbotron">
        <div class="row justify-content-center text-center">
          <div class="col">You are now logged out.</div>
        </div>
      </div>';

      echo $view;
    }
}
