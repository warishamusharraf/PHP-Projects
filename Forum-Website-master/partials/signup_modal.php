<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Signup To iDiscuss</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/forum/partials/_handleSignup.php" method='post'>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" class="form-control" id="email_Sign" name="email_Sign" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password_Sing" name="password_Sign">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confrim Password</label>
                        <input type="password" class="form-control" id="cpassword_Sign" name="cpassword_Sign">
                        <div id="emailHelp" class="form-text">Make Sure' Password is same</div>
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                
            </div>
            
            </form>
        </div>
    </div>
</div>