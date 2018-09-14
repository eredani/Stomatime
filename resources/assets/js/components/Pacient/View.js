
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
import StarRatingComponent from 'react-star-rating-component';
if(document.getElementById('home'))
{
const API = 'https://stomatime.com/api/cabinete';
class SearchBar extends Component {
    constructor(props) {
      super(props);
      this.handleFilterTextChange = this.handleFilterTextChange.bind(this);
      this.handleFilterJudetChange = this.handleFilterJudetChange.bind(this);
    }
    
    handleFilterTextChange(e) {
      this.props.onFilterTextChange(e.target.value);
    }
    handleFilterJudetChange(e) {
        this.props.onFilterJudetChange(e.target.value);
      }
    
    render() {
      return (
       <section>
          <div className="row">
            <div className="col-md-4">
          <input
          className="form-control"
            type="text"
            placeholder="Search for a cabinet by name."
            value={this.props.filterText}
            onChange={this.handleFilterTextChange}
          />
              </div>
          <div className="col-md-4">
                            <div>
                                <select name="judet" className="form-control" onChange={this.handleFilterJudetChange}>
                                    <option value="">Counties</option>
                                    <option value="Alba">Alba</option>
                                    <option value="Arad">Arad</option>
                                    <option value="Arges">Arges</option>
                                    <option value="Bacau">Bacau</option>
                                    <option value="Bihor">Bihor</option>
                                    <option value="Bistrita Nasaud">Bistrita Nasaud</option>
                                    <option value="Botosani">Botosani</option>
                                    <option value="Brasov">Brasov</option>
                                    <option value="Braila">Braila</option>
                                    <option value="Bucuresti">Bucuresti</option>
                                    <option value="Buzau">Buzau</option>
                                    <option value="Caras Severin">Caras Severin</option>
                                    <option value="Calarasi">Calarasi</option>
                                    <option value="Cluj">Cluj</option>
                                    <option value="Constanta">Constanta</option>
                                    <option value="Covasna">Covasna</option>
                                    <option value="Dambovita">Dambovita</option>
                                    <option value="Dolj">Dolj</option>
                                    <option value="Galati">Galati</option>
                                    <option value="Giurgiu">Giurgiu</option>
                                    <option value="Gorj">Gorj</option>
                                    <option value="Harghita">Harghita</option>
                                    <option value="Hunedoara">Hunedoara</option>
                                    <option value="Ialomita">Ialomita</option>
                                    <option value="Iasi">Iasi</option>
                                    <option value="Ilfov">Ilfov</option>
                                    <option value="Maramures">Maramures</option>
                                    <option value="Mehedinti">Mehedinti</option>
                                    <option value="Mures">Mures</option>
                                    <option value="Neamt">Neamt</option>
                                    <option value="Olt">Olt</option>
                                    <option value="Prahova">Prahova</option>
                                    <option value="Satu Mare">Satu Mare</option>
                                    <option value="Salaj">Salaj</option>
                                    <option value="Sibiu">Sibiu</option>
                                    <option value="Suceava">Suceava</option>
                                    <option value="Teleorman">Teleorman</option>
                                    <option value="Timis">Timis</option>
                                    <option value="Tulcea">Tulcea</option>
                                    <option value="Vaslui">Vaslui</option>
                                    <option value="Valcea">Valcea</option>
                                    <option value="Vrancea">Vrancea</option>
                                </select>
                            </div>
            </div>
            </div>
        </section>
      );
    }
}
class Cabinete extends Component {

    render()
    {
        const search = this.props.filterText;
        const judet = this.props.judet;
        const cabs = this.props.cabinete;
        const row = [];
        cabs.forEach((cabinet,index)=>
        {
            if(cabinet.name.toLowerCase().indexOf(search.toLowerCase()) === -1){
                return;
            }
            if(cabinet.judet.indexOf(judet) === -1){
                return;
            }
            row.push(  
                <Cards cabinet={cabinet} count={index} key={index}/>
            )
        })
        return(
            <div className="row flex-row">
            {row}
             <br/>
            </div>
        );
    }

}
class Cards extends Component {
    render()
    {
        const cabinet = this.props.cabinet;
        return(
            <div className="col-lg-3 d-flex">
            <div className="our-cabs-main">
    
            <div className="team-front"><a href={"/view/"+cabinet.id}>
            <img src={ cabinet.img_profile } className="img-fluid" /></a>
            <a href={"/view/"+cabinet.id}><h3>{cabinet.name}</h3></a>
            <p>{cabinet.adresa}</p>
        <div className="star">
            <StarRatingComponent
            name="{this.props.count}"
            starCount={5}
            value={cabinet.stele}
            />
            <div className="dv-star-rating" style={{display: 'inline-block', position: 'relative'}}>
        <label id="countstars" className="dv-star-rating-star dv-star-rating-empty-star" htmlFor="rate1_5"><i style={{fontStyle: 'normal'}}>({cabinet.voturi})</i></label>
        </div>
        </div>
        <div className="cardmedicflow">
            <p className="text-center"><a href={"/view/"+cabinet.id}>
            Learn more!
        </a>
        </p>
        <hr/>
        <cite className="text-center" title="Source Title">"{cabinet.moto}"</cite>
            <hr/>
            <p>{cabinet.descriere}</p>
        </div>
      
        </div>
        </div>
        </div>

        );
    }
}
class Main extends Component {
    constructor(props) {
      super(props);
      this.state = {
        filterText: '',
        judet:'',
        cabinete: []
      };
      
      this.handleFilterTextChange = this.handleFilterTextChange.bind(this);
      this.handleFilterJudetChange = this.handleFilterJudetChange.bind(this);
    }
    componentDidMount() 
    {
            axios.get(API)
      .then((res) => {
      this.setState({
          cabinete:res.data
          
      });
    })
  }
    handleFilterTextChange(filterText) {
      this.setState({
        filterText: filterText
      });
    }
    handleFilterJudetChange(judet) {
        this.setState({
            judet: judet
        });
      }
    render() {
      return (
        <div  className="container-fluid">
       
            <SearchBar
                        filterText={this.state.filterText}
                        filterJudet={this.state.judet}
                        onFilterTextChange={this.handleFilterTextChange}
                        onFilterJudetChange={this.handleFilterJudetChange}
            />
           
            
            <Cabinete
                cabinete={this.state.cabinete}
                filterText={this.state.filterText}
                judet={this.state.judet}
            />
          
        </div>
      );
    }
}
ReactDOM.render(<Main/>, document.getElementById('home'));
}

