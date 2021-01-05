export const addNote = ({ commit }, notes) => {
  commit('PUSH_NOTE', notes)
}
export const deleteNote = ({ commit }, notes) => {
  commit('DELETE_NOTE', notes)
}