import moment from 'moment';

export function formatDate(date) {
  return moment(date).format('DD.MM.YYYY');
}

export function formatBoolean(value) {
    return value ? '+' : '-'
}
