import request from '@/utils/request'

/**
 * 公告列表 - 获取
 * @param {*} timeBegin
 */
export function announceListGet(timeBegin) {
  const data = {
    cmd: 201,
    param: {
      dateRange: timeBegin
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 公告列表 - 添加
 * @param {*} title
 * @param {*} content
 * @param {*} status
 * @param {*} tagArr
 * @param {*} carousel
 * @param {*} note
 * @param {*} areaArr
 * @param {*} terminal
 */
export function announceListAdd(title, content, status, tagArr, carousel, note, areaArr, terminal) {
  const data = {
    cmd: 202,
    param: {
      title: title,
      content: content,
      status: status,
      tagArr: tagArr,
      carousel: carousel,
      note: note,
      areaArr: areaArr,
      terminal: terminal
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 公告列表 - 编辑
 * @param {*} id
 * @param {*} title
 * @param {*} content
 * @param {*} status
 * @param {*} carousel
 * @param {*} note
 */
export function announceListEdit(id, title, content, status, carousel, note) {
  const data = {
    cmd: 203,
    param: {
      id: id,
      title: title,
      content: content,
      status: status,
      carousel: carousel,
      note: note
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}

/**
 * 公告列表 - 删除
 * @param {*} id
 */
export function announceListDel(id) {
  const data = {
    cmd: 204,
    param: {
      id: id
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}
