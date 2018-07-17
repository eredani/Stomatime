import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
class SectionCards extends Component{
    constructor(props) {
        super(props);    
        this.state ={
            weeks:["duminica","luni","marti","miercuri","joi","vineri","sambata"],
            time:null,
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
        var hours = date.getHours();
        var minutes = date.getMinutes();
        hours = hours % 12;
        hours = hours ? hours : 12; 
        hours = hours < 10 ? '0'+hours : hours;
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes;
        return strTime;
      }
    componentDidMount(){
        this.interval = setInterval(() => this.setState({ time: Date.now() }), 60000);
       
    }
    componentWillUnmount() {
        clearInterval(this.interval);
      }
    render()
    {
        var cabinetul=[];
        var medicrandom=[];
        var orar=[];
        var status;
        this.state.weeks.forEach((day,key)=>{
        this.props.cabinet.forEach((cab) => {
            cabinetul=cab;
            medicrandom=cab.doctori[Math.floor(Math.random() * cabinetul.countdoctori)];
            if(cab.program[day])
            {
                orar.push(<p key={key}>{day.charAt(0).toUpperCase()}{day.slice(1)}: {cab.program[day].start} - {cab.program[day].stop}</p>)
            }
            if(cab.program[this.state.day])
            {
                
                if(cab.program[this.state.day].stop > this.curentDate() && cab.program[this.state.day].start < this.curentDate())
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
        }); 
    });
        return(
          <div className="container-fluid">
            <div className="card-deck">
            <div className="card">
                <div className="card-body">
                <h5 className="card-title text-center">Program {status}</h5>
                <div className="text-center cardflow">{orar}</div>
                </div>
            </div>
            <div className="card">
                <div className="card-body">
                <h5 className="card-title text-center">Contact</h5>
                <div className="card-text cardflow text-center">Email: {cabinetul.email} <br/> Număr: {cabinetul.numar}</div>
                <p className="card-text text-center"><small className="text-muted">{cabinetul.adresa}</small></p>
                </div>
            </div>
            <div className="card">
                <div className="card-body">
                <h5 className="card-title text-center">Info</h5>
                <div className="text-center cardflow">Echipa {cabinetul.name} este formată din {cabinetul.countdoctori} medici cu experiență în diferite specializări.</div>
                <p className="card-text text-center"><small className="text-muted">Medic evidențiat: <a href={"https://stomatime.com/view/"+window.config.ID+"/medic/"+medicrandom.id}>{medicrandom.nume}  {medicrandom.prenume}</a></small></p>
                </div>
            </div>
          </div>
          </div>
        );
    }
}
class Main extends Component
{
    constructor(props) {
        super(props);    
        this.state ={
            cabinet:[],
        };
    }
    componentWillMount(){
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
   render()
   {
       return(
        <SectionCards cabinet={this.state.cabinet}/>
       );
   }
}
if(document.getElementById('reactview'))
{
ReactDOM.render(<Main/>, document.getElementById('reactview'));
}

