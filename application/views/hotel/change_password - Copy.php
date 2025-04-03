
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell">

                        <div class="text-center">
                            <h1 class="h2">Change Password</h1>
                            <p class="lead">Update your password securely</p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form action="<?=base_url()?>hotel/update_password" method="post">
                                        <div class="mb-3">
                                            <label class="form-label">Old Password</label>
                                            <input class="form-control form-control-lg" type="password" name="old_password" placeholder="Enter old password" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <input class="form-control form-control-lg" type="password" name="new_password" placeholder="Enter new password" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm New Password</label>
                                            <input class="form-control form-control-lg" type="password" name="confirm_password" placeholder="Confirm new password" required />
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Change Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    
