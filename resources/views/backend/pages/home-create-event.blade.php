@extends('backend.layout.app')
    @section('content')
    {{-- Content body start --}}
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create Event</h4>
                            </div>
                            <div class="card-body">
                                <div class="create-event-form">
                                    <form action="#">
                                        <h5 class="mb-3">General Info</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">Event Title</label>
                                            <input type="email" class="form-control" id="inputEmail4" placeholder="">
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="inputPassword4">Organizer</label>
                                            <input type="password" class="form-control" id="inputPassword4" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCity">Type</label>
                                                <select id="inputState" class="form-control">
                                                    <option value="19">Appearance or Signing</option>
                                                    <option value="17">Attraction</option>
                                                    <option value="18">Camp, Trip, or Retreat</option>
                                                    <option value="9">Class, Training, or Workshop</option>
                                                    <option value="6">Concert or Performance</option>
                                                    <option value="1">Conference</option>
                                                    <option value="4">Convention</option>
                                                    <option value="8">Dinner or Gala</option>
                                                    <option value="5">Festival or Fair</option>
                                                    <option value="14">Game or Competition</option>
                                                    <option value="10">Meeting or Networking Event</option>
                                                    <option value="100">Other</option>
                                                    <option value="11">Party or Social Gathering</option>
                                                    <option value="15">Race or Endurance Event</option>
                                                    <option value="12">Rally</option>
                                                    <option value="7">Screening</option>
                                                    <option value="2">Seminar or Talk</option>
                                                    <option value="16">Tour</option>
                                                    <option value="13">Tournament</option>
                                                    <option value="3">Tradeshow, Consumer Show, or Expo</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="inputState">Category</label>
                                            <select id="inputState" class="form-control">
                                                <option value="118">Auto, Boat &amp; Air</option>
                                                <option value="101">Business &amp; Professional</option>
                                                <option value="111">Charity &amp; Causes</option>
                                                <option value="113">Community &amp; Culture</option>
                                                <option value="115">Family &amp; Education</option>
                                                <option value="106">Fashion &amp; Beauty</option>
                                                <option value="104">Film, Media &amp; Entertainment</option>
                                                <option value="110">Food &amp; Drink</option>
                                                <option value="112">Government &amp; Politics</option>
                                                <option value="107">Health &amp; Wellness</option>
                                                <option value="119">Hobbies &amp; Special Interest</option>
                                                <option value="117">Home &amp; Lifestyle</option>
                                                <option value="103">Music</option>
                                                <option value="199">Other</option>
                                                <option value="105">Performing &amp; Visual Arts</option>
                                                <option value="114">Religion &amp; Spirituality</option>
                                                <option value="120">School Activities</option>
                                                <option value="102">Science &amp; Technology</option>
                                                <option value="116">Seasonal &amp; Holiday</option>
                                                <option value="108">Sports &amp; Fitness</option>
                                                <option value="109">Travel &amp; Outdoor</option>
                                            </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="inputCity">Location</label>
                                            <select id="inputState" class="form-control">
                                                <option selected value="online">Online event</option>

                                                <option value="tba">To be announced</option>
                                            </select>
                                            </select>
                                        </div>

                                        <h5 class="my-4">Date and time</h5>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCity">Event Starts</label>
                                                <input type="password" class="form-control" id="inputPassword4" placeholder="">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputState">Start Time</label>
                                                <input type="password" class="form-control" id="inputPassword4" placeholder="">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputCity">Event Ends</label>
                                                <input type="password" class="form-control" id="inputPassword4" placeholder="">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputState">End Time</label>
                                                <input type="password" class="form-control" id="inputPassword4" placeholder="">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck">
                                            <label class="form-check-label" for="gridCheck">
                                                Check me out
                                            </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Sign in</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endsection
        
        