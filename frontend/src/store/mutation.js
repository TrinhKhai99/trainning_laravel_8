export const PUSH_NOTE = (state, notes) => {
    state.notifications.push({
      ...notes,
      id: (Math.random().toString(36) + Date.now().toString(36).substr(2))
    })
  }
  export const DELETE_NOTE = (state, notesDelete) => {
    state.notifications = state.notifications.filter(note => {
      return note.id != notesDelete.id
    })
  }