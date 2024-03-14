<article>
                <div id="Base" class="managements">Welcome Admin Page</div>
                <div id="RoleManagement" class="managements">Role Admin Page</div>
                <div id="UserManagement" class="managements">
                    <nav>
                        <ul>
                            <?php foreach ($userArrays as $userInfo) { ?>
                                <li>
                                    <a class="infoA" <?php echo "href='http://localhost:3000/adminpage/userinfo/" . $userInfo['user_pk'] . "'"; ?>>
                                        <?php echo $userInfo["user_id"] ?>
                                    </a>
                                </li>
                            <?php }; ?>
                        </ul>
                    </nav>
                </div>
                <div id="BoardManagement" class="managements">
                    <nav>
                        <ul>
                            <?php foreach ($boardArrays as $boardInfo) { ?>
                                <li>
                                    <a class="infoA" <?php echo "href='http://localhost:3000/adminpage/boardinfo/" . $boardInfo['id'] . "'"; ?>>
                                        <?php echo $boardInfo["title"] ?>
                                    </a>
                                </li>
                            <?php }; ?>
                        </ul>
                    </nav>
                </div>
            </article>