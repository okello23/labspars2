<div>
    <div class="card">
        <div class="card-header">
            @include('livewire.facility.visits.inc.visit-header')
        </div>
        <!-- Persons Supervised -->
        <div class="card-body">
            <div>
                <h2>Persons Supervised</h2>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Sex (F/M)</th>
                            <th>Profession</th>
                            <th>Contact/Phone No.</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><input type="text" name="supervised_name_1"></td>
                            <td><input type="text" name="supervised_sex_1"></td>
                            <td><input type="text" name="supervised_profession_1"></td>
                            <td><input type="text" name="supervised_phone_1"></td>
                            <td><input type="email" name="supervised_email_1"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input type="text" name="supervised_name_2"></td>
                            <td><input type="text" name="supervised_sex_2"></td>
                            <td><input type="text" name="supervised_profession_2"></td>
                            <td><input type="text" name="supervised_phone_2"></td>
                            <td><input type="email" name="supervised_email_2"></td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>

            <!-- Supervisors -->
            <div>
                <h2>Supervisors</h2>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact/Phone No.</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><input type="text" name="supervisor_name_1"></td>
                            <td><input type="text" name="supervisor_phone_1"></td>
                            <td><input type="text" name="supervisor_title_1"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input type="text" name="supervisor_name_2"></td>
                            <td><input type="text" name="supervisor_phone_2"></td>
                            <td><input type="text" name="supervisor_title_2"></td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>

            <!-- Storage Details -->
            <div>
                <h2>Laboratory Supply Storage</h2>
                <h3>D1: Where are Laboratory supplies MAINLY stored in the facility?</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Store</th>
                            <th>Tick (✔)</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Main store</td>
                            <td><input type="checkbox" name="main_store"></td>
                            <td><input type="text" name="main_store_comment"></td>
                        </tr>
                        <tr>
                            <td>Laboratory store</td>
                            <td><input type="checkbox" name="lab_store"></td>
                            <td><input type="text" name="lab_store_comment"></td>
                        </tr>
                        <tr>
                            <td>Pharmacy store</td>
                            <td><input type="checkbox" name="pharmacy_store"></td>
                            <td><input type="text" name="pharmacy_store_comment"></td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>

                <h3>D2: Where ELSE are Laboratory supplies stored in the facility?</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Store</th>
                            <th>Tick (✔)</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Main store</td>
                            <td><input type="checkbox" name="else_main_store"></td>
                            <td><input type="text" name="else_main_store_comment"></td>
                        </tr>
                        <tr>
                            <td>Laboratory store</td>
                            <td><input type="checkbox" name="else_lab_store"></td>
                            <td><input type="text" name="else_lab_store_comment"></td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>

            <!-- Stock Cards -->
            <div>
                <h2>Stock Cards</h2>
                <h3>D3: Does the facility use stock cards to track the use of laboratory supplies?</h3>
                <label>Yes <input type="radio" name="uses_stock_cards" value="yes"></label>
                <label>No <input type="radio" name="uses_stock_cards" value="no"></label>

                <h3>D4: Where are stock cards kept in the facility?</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Store</th>
                            <th>Tick (✔)</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Main store</td>
                            <td><input type="checkbox" name="stock_main_store"></td>
                            <td><input type="text" name="stock_main_store_comment"></td>
                        </tr>
                        <tr>
                            <td>Laboratory store</td>
                            <td><input type="checkbox" name="stock_lab_store"></td>
                            <td><input type="text" name="stock_lab_store_comment"></td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>

                <h3>D5: If stock cards are kept in multiple places, how is the consumption reconciled with the main
                    store/stock card?</h3>
                <textarea name="reconciliation_comments" rows="3" cols="80"></textarea>
            </div>
        </div>
    </div>
