<template>

  <div class="container tableau">
    <h1>Liste des employers avec leur salaire</h1>
    <button class="btn btn-primary addClass" @click="boutonAjout"><i class="fa-plus"></i>Ajouter un nouvel employer</button>

    <div class="scroll-table">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Nombre de jours</th>
            <th scope="col">Taux journalier</th>
            <th scope="col">Salaire</th>
            <th scope="col" class="bouton"></th>
            <th scope="col" class="bouton"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="employer in employers" :key="employer.numEmp" class="line">
            <td>{{ employer.nom }}</td>
            <td>{{ employer.nbrJour }}</td>
            <td>{{ employer.taux | monetize}}</td>
            <td>{{ employer.taux * employer.nbrJour | monetize}}</td>
            <td><button class="btn btn-primary btnmodif" @click="modifier(employer)"><i class="fas fa-edit"></i></button></td>
            <td><button class="btn btn-secondary btndelete" @click="deletion(employer.numEmp)"><i class="fas fa-trash"></i></button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <section class="stat">
      <h5>Salaire total: <span>{{ total | monetize}}</span></h5>
      <h5>Salaire minimal: <span>{{ extremum.minimum | monetize }}</span></h5>
      <h5>Salaire maximal: <span>{{ extremum.maximum | monetize}}</span></h5>
    </section>

    <Transition name="edit_form">
      <div v-if="ajout" class="formulaire">
        <h2><i class="fas fa-add"></i> Ajout</h2>
        <div class="form-group">
          <input type="text" class="form-control add-input" ref="nom" placeholder="Saisir votre nom" v-model="nom">
        </div>
        <div class="form-group">
          <input type="number" class="form-control add-input"  placeholder="Nombre de jours" v-model="nbrJour">
        </div>
        <div class="form-group">
          <input type="number" class="form-control add-input"  placeholder="Taux journalier" v-model="taux">
        </div>
        <div class="btn-group">
          <button type="submit" class="btn btn-primary" @click.prevent="ajouter()">Ajouter</button>
          <button class="btn btn-secondary" @click="cancelAdd">Annuler</button>
        </div>
      </div>
    </Transition>

    <Transition name="edit_form">
      <div v-show="editing" class="formulaire">
        <h2><i class="fas fa-edit"></i> Modification</h2>
        <div class="form-group">
          <label for="name">Nom:</label>
          <input type="text" class="form-control" ref="nomModif" placeholder="Saisir votre nom" v-model="nom">
        </div>
        <div class="form-group">
          <label for="email">Nombre de jours:</label>
          <input type="number" class="form-control"  placeholder="Nombre de jours" v-model="nbrJour">
        </div>
        <div class="form-group">
          <label for="email">Taux journalier:</label>
          <input type="number" class="form-control"  placeholder="Taux journalier" v-model="taux">
        </div>
        <div class="btn-group">
          <button type="submit" class="btn btn-primary" @click.prevent="save(numEmp)">Confirmer</button>
          <button class="btn btn-secondary" @click="cancelEdit">Annuler</button>
        </div>
      </div>
    </Transition>

    <Transition name="edit_form">
      <div v-show="suppr" class="formulaire">
        <h2><i class="fas fa-trash"></i> Suppresssion</h2>
        <p>Voulez-vous supprimer l'employer n° {{ numEmp }}</p>
        <div class="btn-group">
          <button type="submit" class="btn btn-primary" @click.prevent="supprimer(numEmp)">Confirmer</button>
          <button class="btn btn-secondary" @click="suppr = false">Annuler</button>
        </div>
      </div>
    </Transition>
  </div>

</template>
<script>
import axios from 'axios'
export default{
  data () {
    return {
      editing: false,
      ajout: false,
      suppr: false,
      nom: '',
      nbrJour: '',
      taux: '',
      numEmp: '',
      employers: []
    }
  },
  methods: {
    modifier (employer) {
      this.nom = employer.nom
      this.nbrJour = employer.nbrJour
      this.taux = employer.taux
      this.numEmp = employer.numEmp
      this.editing = true
    },
    save (numEmp) {
      this.editing = false
      var donnees = new FormData()
      donnees.set('nom', this.nom)
      donnees.set('nbrJour', this.nbrJour)
      donnees.set('taux', this.taux)
      donnees.set('numEmp', numEmp)

      axios.post('http://localhost/employer/index.php?type=modification', donnees).then(reponse => {
        this.employers = reponse.data
      }).catch(error => {
        console.log(error)
      })
    },
    boutonAjout () {
      this.nom = ''
      this.numEmp = ''
      this.taux = ''
      this.nbrJour = ''
      this.ajout = true
    },
    cancelAdd () {
      this.ajout = false
    },
    cancelEdit () {
      this.editing = false
    },
    ajouter () {
      this.ajout = false
      var donnees = new FormData()
      donnees.set('nom', this.nom)
      donnees.set('nbrJour', this.nbrJour)
      donnees.set('taux', this.taux)

      axios.post('http://localhost/employer/index.php?type=ajout', donnees).then(reponse => {
        this.employers = reponse.data
      }).catch(error => {
        console.log(error)
      })
    },
    supprimer (employer) {
      this.suppr = false
      var donnees = new FormData()
      donnees.set('numEmp', employer)
      axios.post('http://localhost/employer/index.php?type=suppression', donnees).then(reponse => {
        this.employers = reponse.data
      }).catch(error => {
        console.log(error)
      })
    },
    deletion (numEmp) {
      this.suppr = true
      this.numEmp = numEmp
    },
    minmax () {
      let min = 0
      let max = 0
      let i = 0

      this.employers.forEach(employer => {
        if (i === 0) {
          min = employer.taux * employer.nbrJour
        } else if (i === 1) {
          max = employer.taux * employer.nbrJour

          if (min > max) {
            let rechange = min
            min = max
            max = rechange
          }
        } else {
          var salaire = employer.taux * employer.nbrJour
          if (max < salaire) {
            max = salaire
          }
          if (min > salaire) {
            min = salaire
          }
        }
        i++
      })

      return {maximum: max, minimum: min}
    }
  },
  mounted: function () {
    axios.get('http://localhost/employer/index.php?type=listage').then(reponse => {
      this.employers = reponse.data
    }).catch(error => {
      console.log(error)
    })
  },
  computed: {
    total () {
      let total = 0
      this.employers.forEach(employer => {
        total += (employer.taux * employer.nbrJour)
      })

      return total
    },
    extremum () {
      return this.minmax()
    }
  },
  filters: {
    monetize (money) {
      const formatter = new Intl.NumberFormat('fr-FR', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 })
      return formatter.format(money) + ' Ar'
    }
  }
}
</script>
<style src="./style.css"></style>
