import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
import StarRatingComponent from 'react-star-rating-component';
import {NotificationContainer, NotificationManager} from 'react-notifications';
import 'react-notifications/lib/notifications.css';
import {withGoogleMap,GoogleMap,Marker} from "react-google-maps";
if(document.getElementById('reactview'))
{
    const cabID = window.config.ID;
    const Token = window.config.csrfToken;
    class SectionCards extends Component{
        constructor(props) {
            super(props);    
            this.state ={
                weeks:["duminica","luni","marti","miercuri","joi","vineri","sambata"],
                day:null
            };
            this.curentDate=this.curentDate.bind(this);
        }
        componentWillMount(){
            var date = new Date();
            var day = this.state.weeks[date.getDay()];
            this.setState({day:day});
        
        }
        curentDate() {
            var date = new Date();
            var ora = date.getHours();
            var minute = date.getMinutes();
            ora = ora % 24;
            ora = ora ? ora : 0;
            ora = ora < 10 ? '0'+ora : ora;
            minute = minute < 10 ? '0'+minute : minute;
            var time = ora + ':' + minute;
            return time;
        }
        onStarClick(nextValue, prevValue, name) {

            var scor = nextValue;

            axios.post(`https://stomatime.com/sendscore`,
                { score: scor,
                cabinet: cabID,
                csrfToken:Token }
                )
                .then(res => {
                    switch (res.data.status) {
                        case 'fail': {

                            NotificationManager.error('Error', res.data.msg, 3000);
                            break;
                        }
                        case 'success': {
                            this.props.updateData();
                            NotificationManager.success('Success', res.data.msg, 3000);
                            this.forceUpdate();
                            break;
                        }
                            break;
                    }

                })
        }
        render() {
            var cabinetul=[];
            var medicrandom=[];
            var orar=[];
            var status;
            this.state.weeks.forEach((day,key)=>{
            this.props.cabinet.forEach((cab) => {
                cabinetul=cab;
                if(cabinetul.countdoctori>0)
                    medicrandom=cab.doctori[Math.floor(Math.random() * cabinetul.countdoctori)];
                else
                    medicrandom=null;
                if(cab.program!==null)
                {
                if(cab.program[day])
                {
                    orar.push(<div className="col-lg-6 col-md-4 col-sm-4  text-center" key={key}> <p className="text-center"><b>{day.charAt(0).toUpperCase()}{day.slice(1)}: </b>{cab.program[day].start}-{cab.program[day].stop}</p></div>)
                }
                if(cab.program[this.state.day])
                {

                    if(this.curentDate() < cab.program[this.state.day].stop  &&  this.curentDate() > cab.program[this.state.day].start)
                    {
                        status=(<span className="badge badge-success">Deschis</span>);
                    }
                    else
                    {
                        status=(<span className="badge badge-danger">Inchis</span>);
                    }
                }
                else
                {
                    status=(<span className="badge badge-danger">Inchis</span>);
                }
                }
                else
                {
                    status=(<span className="badge badge-danger">Inchis</span>);
                }

            });
        });
            return(
            <div className="row">
            <div  className="col-lg-3 col-md-4 col-sm-6 d-flex text-center">
                    <div className="our-team-main">

                    <div className="team-front">
                    <h2>{status}</h2>
                    <div className="row">
                    {orar}
                    </div>
                    <div className="star">
                <StarRatingComponent
            name="rate"
            starCount={5}
            value={cabinetul.scor}
            onStarClick={this.onStarClick.bind(this)}
            />
            </div>
                    </div>
                    </div>
                </div>
                        
                        <div  className="col-lg-3 col-md-4 col-sm-6 d-flex text-center">
                        <div className="our-team-main">
        
                        <div className="team-front"> 
                        <h2>Contact</h2>
                        <div className="card-text cardflow text-center">Email: {cabinetul.email} <br/> {cabinetul.numar!==null ? "Număr:" + cabinetul.numar : ""}</div>
                            <p className="card-text text-center"><small className="text-muted">{cabinetul.adresa}</small></p>
                        
                        </div>
                    </div>
                    </div>
                    <div  className="col-lg-3 col-md-4 col-sm-6 d-flex text-center">
                        <div className="our-team-main">
        
                        <div className="team-front">
                        <h2>Info</h2>
                        {
                        medicrandom!==null
                        ?
                        <div>
                            <div className="text-center cardflow">Echipa {cabinetul.name} este formată din {cabinetul.countdoctori} medici cu experiență în diferite specializări.</div>

                    <p className = " text-center" > <small className="text-muted">Medic evidențiat &nbsp;
                    <a href={"https://stomatime.com/view/"+window.config.ID+"/medic/"+medicrandom.id}>
                        {medicrandom.nume} {medicrandom.prenume}
                    </a>
                    </small>
                    </p>
                    </div>
                    : ""
                    }
                        
                        </div>
                    </div>
                    </div>
            </div>
            );
        }
    }
    class ToolServiciiSpecializari extends  Component{
        constructor(props) {
            super(props);

        }
        render(){



            return(

                    <div className="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <div className="card">
                            <div className={"card-block block-"+this.props.index}>
                            <h3 className="card-title text-center">{this.props.spec.specializare}</h3>
                            </div>
                        </div>
                    </div>

            );
        }
    }
    class SectionSpecializari extends  Component{
        constructor(props) {
            super(props);

        }
        render()
        {
            var specializari={};
            var card=[];
            var moto=null;
            this.props.cabinet.forEach(data=>{
                moto=data.moto;
                data.specializari.forEach((specializare,key)=>{

                    if(key<6){
                        card.push(<ToolServiciiSpecializari key={key} index={key+1} spec={specializare}/>);
                    }
                });

            });


            return(
                <section id="what-we-do">
                    <div className="container-fluid">
                    <h2 className="section-title mb-2 h1">Specializările disponibile</h2>
                    <p className="text-center text-muted h5">{moto}</p>
            <div className="row mt-5">
            {card}

            </div>
            <p className="text-center"><a className="text-muted h5" href={"https://stomatime.com/view/"+window.config.ID+"/servicii"}>Vezi mai multe specializări si detalii despre acestea</a></p>
            <h2 className="section-title mb-2 h1">Medici</h2>
            </div>
            </section>
        );
        }
    }
    class SectionPersonal extends  Component{
        render() {
            var medici=[];
            this.props.cabinet.forEach(cab=>{
            cab.doctori.forEach((doctor,key)=>{
                var spec=[];
                doctor.specializari.forEach((specializare,index)=>{
                    spec.push(<li className="text-center list-group-item" key={index}>{specializare[0].specializare}</li>)
            });
                if(doctor.descriere!==null && doctor.img_profile!==null && doctor.specializari.length>0 && doctor.orar!==null){
                    medici.push(
                    <div key={key} className="col-lg-3 col-md-4 col-sm-6 d-flex">
                        <div className="our-team-main">

                        <div className="team-front">
                        <a href={"https://stomatime.com/view/"+window.config.ID+"/medic/"+doctor.id}><img src={"https://stomatime.com/"+doctor.img_profile} className="img-fluid" /></a>
                        <a href={"https://stomatime.com/view/"+window.config.ID+"/medic/"+doctor.id}><h3>{doctor.nume} {doctor.prenume}</h3></a>
                    <p>{doctor.profesie} </p>
                    </div>

                    <div className="team-back">
                        <div className="cardmedicflow">
                        <p className="text-center"><a href={"https://stomatime.com/view/"+window.config.ID+"/medic/"+doctor.id}>
                        Fă-ti o programare.
                    </a></p>
                    {doctor.sala.length > 0 && <div>< p className = "text-center" > Cabinetul dotorului < b > {doctor.nume}</b> se afla la etajul <b>{doctor.sala[0].etaj} </b> sala numarul <b>{doctor.sala[0].numar}</b>.</p><hr/></div>}

                        <p className="text-center">
                        {doctor.descriere}
                        </p>
                        </div>
                    </div>
                    </div>
                    </div>
                    );
                }

            });
        });
            return (
                <div className="container-fluid">

                <div className="row">
                {medici}


            </div>
            </div>
            );
        }
    }
    class Map extends Component {
        constructor(props) {
            super(props);
        }
        render()
        {
            const GoogleMapExample = withGoogleMap(props => (
                <GoogleMap
            defaultCenter = { { lat: parseFloat(this.props.lat), lng: parseFloat(this.props.long) } }
            defaultZoom = { 15 }>
                <Marker position={{ lat: parseFloat(this.props.lat), lng: parseFloat(this.props.long) }} />
                </GoogleMap>
        ));
            return(
                <div>
                <GoogleMapExample
            containerElement={ <div id="map-container" style={{ height: `240px`, width: '100%' }} /> }
            mapElement={ <div style={{ height: `100%` }} /> }
            />
            </div>
        );
        }
    }
    class Footer extends  Component{
        render(){
            var today = new Date();
            var year = today.getFullYear();
            var lat,long,name;
            this.props.cabinet.forEach(data=>{
            lat=data.lat;
            long=data.long;
            name=data.name;
            });
            return(
                <footer id="myFooter">
                <div className="container">
                {
                lat!==null?
                < Map
                lat = {lat}
                long = {long}
                />
                :
                ""
                }
                </div>
                <div className="footer-copyright">
                    <p>© {year} Copyright {name} </p>
                </div>
                </footer>
            );
        }
    }
    class Main extends Component {
        constructor(props) {
            super(props);    
            this.state ={
                cabinet:[],
            };
            this.UpdateData=this.UpdateData.bind(this);
        }
        UpdateData()
        {
            try {
                axios.get(`https://stomatime.com/api/cabinete/`+ window.config.ID)
                    .then(res => {
                        this.setState({
                            cabinet:res.data
                        });
                    })
            } catch (error) {
                console.log("Eroare la API");
            }
        }
        componentDidMount(){
            this.interval = setInterval(() => this.UpdateData(), 60000);
        }
        componentWillUnmount() {
            clearInterval(this.interval);
        }
        componentWillMount()
        {
            this.UpdateData();
        }
        render()
    {
        return(
            <div className="container-fluid">
            <SectionCards updateData={this.UpdateData} cabinet={this.state.cabinet}/>
            <SectionSpecializari cabinet={this.state.cabinet}/>
            <SectionPersonal cabinet={this.state.cabinet}/>
            <Footer cabinet={this.state.cabinet}/>
            <NotificationContainer/>
        </div>
        );
        }
    }
    ReactDOM.render(<Main/>, document.getElementById('reactview'));
}

