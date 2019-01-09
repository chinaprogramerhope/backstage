import request from '@/utils/request'

/**
 * 公告列表 - 获取
 * @param {*} type
 * @param {*} timeBegin
 */
export function announceListGet(type, timeBegin) {
  const data = {
    cmd: 201,
    param: {
      type: type,
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
 */
export function announceListAdd() {
  const data = {
    cmd: 202,
    param: {
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
 */
export function announceListEdit() {
  const data = {
    cmd: 203,
    param: {
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
 * @param {*} announceId
 */
export function announceListDel(announceId) {
  const data = {
    cmd: 204,
    param: {
      announceId: announceId
    }
  }

  var ret = request({
    method: 'post',
    data
  })

  return ret
}
